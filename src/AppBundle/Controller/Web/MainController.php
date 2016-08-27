<?php

namespace AppBundle\Controller\Web;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MainController extends Controller
{
    /**
     * @Route("/new")
     * @Method("GET")
     * @Template()
     */
    public function writeArticleAction()
    {
        return [
            'title' => 'Write a new article',
        ];
    }
}
