<?php

namespace AppBundle\Controller\Web;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class AuthenticationController
 * @package AppBundle\Controller\Web
 */
class AuthenticationController extends Controller
{
    /**
     * @Route("/login", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function loginAction()
    {
        return [
            'title' => 'Login',
        ];
    }
}