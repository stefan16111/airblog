<?php

namespace AirblogBundle\Twig\Extension;

class BlogExtension extends \Twig_Extension {

    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry 
     */
    private $doctrine;
    private $printCategoryList;

    function __construct(\Doctrine\Bundle\DoctrineBundle\Registry $doctrine) {
        $this->doctrine = $doctrine;
    }

    public function getFunctions() {
        return [
            new \Twig_SimpleFunction('categoryList', [$this, 'categoriesList'], [
                'is_safe' => ['html'],
                'needs_environment' => true
                    ]),
            new \Twig_SimpleFunction('printMenu', [$this, 'printMainMenu'], [
                'is_safe' => ['html'],
                'needs_environment' => true
                    ]),
            new \Twig_SimpleFunction('printTags', [$this, 'tagsCloud'], [
                'is_safe' => ['html'],
                'needs_environment' => true
                    ]),
        ];
    }

    public function categoriesList(\Twig_Environment $env) {
        if (!isset($this->printCategoryList)) {
            $categoryRepo = $this->doctrine->getRepository('AirblogBundle:Category');
            $this->printCategoryList = $categoryRepo->findAll();
        }
        return $env->render("AirblogBundle:Template:categoriesList.html.twig", ['categoriesList' => $this->printCategoryList]);
    }

    public function printMainMenu(\Twig_Environment $env) {
        $mainMenu = [
            'home' => 'blog_index',
            'o mnie' => 'blog_about',
            'kontakt' => 'blog_contact'
        ];
        return $env->render("AirblogBundle:Template:mainMenu.html.twig", ['mainMenu' => $mainMenu]);
    }

    public function tagsCloud(\Twig_Environment $env, $limit = 40, $minFontSize = 1, $maxFontSize = 3.5) {
        $tagRepo = $this->doctrine->getRepository('AirblogBundle:Tag');
        $tagsList = $tagRepo->getTagsListOcc();
        $tagsList = $this->prepareTagsCloud($tagsList, $limit, $minFontSize, $maxFontSize);

        return $env->render('AirblogBundle:Template:tagsCloud.html.twig', ['tagsList' => $tagsList]);
    }

    protected function prepareTagsCloud($tagsList, $limit, $minFontSize, $maxFontSize) {
        $occs = array_map(function($row) {
            return (int) $row['occ'];
        }, $tagsList);

        $minOcc = min($occs);
        $maxOcc = max($occs);

        $spread = $maxOcc - $minOcc;

        $spread = ($spread == 0) ? 1 : $spread;

        usort($tagsList, function($a, $b) {
            $ao = $a['occ'];
            $bo = $b['occ'];

            if ($ao === $bo)
                return 0;

            return ($ao < $bo) ? 1 : -1;
        });

        $tagsList = array_slice($tagsList, 0, $limit);

        shuffle($tagsList);

        foreach ($tagsList as &$row) {
            $row['fontSize'] = round(($minFontSize + ($row['occ'] - $minOcc) * ($maxFontSize - $minFontSize) / $spread), 2);
        }

        return $tagsList;
    }

    public function getName() {
        return 'airblog';
    }

}
