<?php

namespace AirblogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PostsController extends Controller
{
    protected $itemsLimit = 3;
    
    /**
     * @Route("/{page}", name = "blog_index", defaults = {"page" = 1}, requirements = {"page" = "\d+"})
     * 
     * @Template()
     */
    public function indexAction($page)
    {
        $PostRepo = $this->getDoctrine()->getRepository('AirblogBundle:Post');
        //$allposts = $PostRepo->findBy(array(), array('publishedDate' => 'desc'));
        
        $qb = $PostRepo->getQueryBuilder(array(
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC'
            ));
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $this->itemsLimit);
        
        return ['pagination' => $pagination,
            ];
    }
    
    /**
     * @Route("/{slug}", name = "blog_post")
     * @Template()
     */
    public function postAction($slug)
    {
        return array();
    }
    
    /**
     * @Route("/category/{slub}/{page}", name = "blog_category", defaults = {"page" = 1}, requirements = {"page" = "\d+"})
     * @Template()
     */
    public function categoryAction()
    {
        return array();
    }
    
    /**
     * @Route("/tag/{slug}/{page}", name = "blog_tag", defaults = {"page" = 1}, requirements = {"page" = "\d+"})
     * @Template()
     */
    public function tagAction($slug)
    {
        return array();
    }
}
