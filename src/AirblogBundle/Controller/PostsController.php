<?php

namespace AirblogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PostsController extends Controller {

    protected $itemsLimit = 3;

    /**
     * @Route("/{page}", name = "blog_index", defaults = {"page" = 1}, requirements = {"page" = "\d+"})
     * 
     * @Template("AirblogBundle:Posts:postList.html.twig")
     */
    public function indexAction($page) {

        $pagination = $this->getPaginatedPosts([
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC',
                ], $page);

        return ['pagination' => $pagination,
            'listTitle' => 'Najnowsze wpisy'
        ];
    }

    /**
     * @Route("/search/{page}", name = "blog_search", defaults = {"page" = 1}, requirements = {"page" = "\d+"})
     * 
     * @Template("AirblogBundle:Posts:postList.html.twig")
     */
    public function searchAction(\Symfony\Component\HttpFoundation\Request $request, $page) {

        $searchParam = $request->query->get('search');
        
        $pagination = $this->getPaginatedPosts([
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC',
            'search' => $searchParam,
                ], $page);

        return ['pagination' => $pagination,
            'listTitle' => sprintf('Wyniki wyszukiwania frazy "%s" ', $searchParam),
            'searchParam' => $searchParam
        ];
    }

    /**
     * @Route("/{slug}", name = "blog_post")
     * @Template()
     */
    public function postAction($slug) {
        return array();
    }

    /**
     * @Route("/category/{slug}/{page}", name = "blog_category", defaults = {"page" = 1}, requirements = {"page" = "\d+"})
     * @Template("AirblogBundle:Posts:postList.html.twig")
     */
    public function categoryAction($slug, $page) {

        $pagination = $this->getPaginatedPosts([
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC',
            'categorySlug' => $slug,
                ], $page);

        $CategoryRepo = $this->getDoctrine()->getRepository('AirblogBundle:Category');
        $Category = $CategoryRepo->findOneBySlug($slug);

        return ['pagination' => $pagination,
            'listTitle' => sprintf('Wpisy w kategorii %s', $Category->getName())
        ];
    }

    /**
     * @Route("/tag/{slug}/{page}", name = "blog_tag", defaults = {"page" = 1}, requirements = {"page" = "\d+"})
     * @Template("AirblogBundle:Posts:postList.html.twig")
     */
    public function tagAction($slug, $page) {

        $TagRepo = $this->getDoctrine()->getRepository('AirblogBundle:Tag');
        $Tag = $TagRepo->findOneBySlug($slug);

        $pagination = $this->getPaginatedPosts([
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC',
            'tagSlug' => $slug,
                ], $page);

        return ['pagination' => $pagination,
            'listTitle' => sprintf('Wpisy z tagiem %s', $Tag->getName())
        ];
    }

    protected function getPaginatedPosts(array $parms = [], $page) {
        $PostRepo = $this->getDoctrine()->getRepository('AirblogBundle:Post');
        $qb = $PostRepo->getQueryBuilder($parms);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $this->itemsLimit);

        return $pagination;
    }

}
