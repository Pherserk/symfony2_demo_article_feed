<?php

namespace AppBundle\Controller\Web;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MainController extends Controller
{
    /**-
     * @Route("/", name="app_start")
     */
    public function appStartAction(Request $request)
    {
        return new Response('app starts here', 200);
    }
}