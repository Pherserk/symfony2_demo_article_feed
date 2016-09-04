<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\Quote;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class QuoteController
 * @package AppBundle\Controller\Api
 *
 * @Route("/api/quotes")
 */
class QuoteController extends Controller
{
    /**
     * @Route("", options={"expose"=true})
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['articleId'])) {
            return new JsonResponse('Missing article', Response::HTTP_NOT_ACCEPTABLE);
        }

        if (!isset($data['text'])) {
            return new JsonResponse('Missing text', Response::HTTP_NOT_ACCEPTABLE);
        }

        # We fake the logged user for semplicity
        $user = $this->get('app.fake_user_provider')->get('Username1');

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($data['articleId']);

        $quote = new Quote($user, $article, $data['text']);

        $em->persist($quote);
        $em->flush();

        $response = new Response(
            $this
                ->container
                ->get('jms_serializer')
                ->serialize($quote, 'json'),
            Response::HTTP_CREATED
        );

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
