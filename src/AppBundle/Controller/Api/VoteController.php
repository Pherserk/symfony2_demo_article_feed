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

/**
 * Class VoteController
 * @package AppBundle\Controller\Api
 *
 * @Route("/api/votes")
 */
class VoteController extends Controller
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

        if (!isset($data['rate'])) {
            return new JsonResponse('Missing rate', Response::HTTP_NOT_ACCEPTABLE);
        }

        if (!in_array($data['rate'], range(0,5))) {
            return new JsonResponse('Rate should be an integer value between 0 and 5', Response::HTTP_NOT_ACCEPTABLE);
        }

        # We fake the logged user for semplicity
        $user = $this->get('app.fake_user_provider')->get('Username1');

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