<?php

namespace AirblogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PagesController extends Controller
{
    /**
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }
    
    /**
     * @Template()
     */
    public function contactAction()
    {
        return array();
    }
    
}
