<?php

namespace AirblogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PostsController extends Controller
{
    /**
     * @Route("/{page}", name = "blog_index", defaults = {"page" = 1}, requirements = {"page" = "\d+"})
     * 
     * @Template()
     */
    public function indexAction($page)
    {
        return array();
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
