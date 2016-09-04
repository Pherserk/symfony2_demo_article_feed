<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\Article;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class ArticleController
 * @package AppBundle\Controller\Api
 *
 * @Route("/api/articles")
 */
class ArticleController extends Controller
{
    /**
     * @Route("", options={"expose"=true})
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['title'])) {
            return new JsonResponse('Missing title', Response::HTTP_NOT_ACCEPTABLE);
        }

        if (!isset($data['text'])) {
            return new JsonResponse('Missing text', Response::HTTP_NOT_ACCEPTABLE);
        }

        # We fake the logged user for semplicity
        $user = $this->get('app.fake_user_provider')->get('Username1');

        $article = new Article($user, $data['title'], $data['text']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        $response = new Response(
            $this
                ->container
                ->get('jms_serializer')
                ->serialize($article, 'json'),
            Response::HTTP_CREATED
        );

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/{articleId}", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction(Request $request, $articleId)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($articleId);

        $response = new Response(
            $this
                ->container
                ->get('jms_serializer')
                ->serialize($article, 'json'),
            Response::HTTP_FOUND
        );

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}

