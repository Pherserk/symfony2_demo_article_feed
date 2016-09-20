<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
     * @Security("is_granted('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $this->get('json_api.validator.json_request_validator')
            ->validate($request);

        $data = json_decode($request->getContent(), true);

        if (!isset($data['title'])) {
            return new JsonResponse('Missing title', Response::HTTP_NOT_ACCEPTABLE);
        }

        if (!isset($data['text'])) {
            return new JsonResponse('Missing text', Response::HTTP_NOT_ACCEPTABLE);
        }

        $user = $this->getUser();

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
        $this->get('json_api.validator.json_request_validator')
            ->validate($request);
        
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

