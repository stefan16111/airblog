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
                'needs_environment' => true // Tell twig we need the environment
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

    public function getName() {
        return 'airblog';
    }

}
