<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\User;
use AppBundle\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class VoteController extends Controller
{
    /**
     * @Route("/api/votes")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['articleId'])) {
            return new JsonResponse('Missing article', Response::HTTP_NOT_ACCEPTABLE);
        }

        if (!isset($data['rate'])) {
            return new JsonResponse('Missing rate', Response::HTTP_NOT_ACCEPTABLE);
        }

        # We fake the logged user for semplicity
        $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findOneBy(['name' => 'Username1']);

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($data['articleId']);

        $vote = new Vote($user, $article, $data['rate']);

        $em->persist($vote);
        $em->flush();

        $response = new Response(
            $this
                ->container
                ->get('jms_serializer')
                ->serialize($vote, 'json'),
            Response::HTTP_CREATED
        );

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}