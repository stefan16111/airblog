<?php

namespace Common\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="blog_login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $session = $this->get('session');
        
        if($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)){
            $loginError = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        }else{
            $loginError = $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        }
        
        $userName = $session->get(SecurityContextInterface::LAST_USERNAME);
        
        return [
            'loginError' => $loginError,
            'userName' => $userName
            ];
    }
}
