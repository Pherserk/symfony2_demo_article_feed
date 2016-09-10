<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class UserController
 * @package AppBundle\Controller\Api
 *
 * @Route("/api/users")
 */
class UserController extends Controller
{
    /**
     * @Route("", options={"expose"=true})
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['username']) || empty($data['password'])) {
            return new JsonResponse('Missing username', Response::HTTP_NOT_ACCEPTABLE);
        }

        if (!isset($data['password']) || empty($data['password'])) {
            return new JsonResponse('Missing password', Response::HTTP_NOT_ACCEPTABLE);
        }

        if (!isset($data['email']) || empty($data['email'])) {
            return new JsonResponse('Missing email', Response::HTTP_NOT_ACCEPTABLE);
        }

        if (!isset($data['mobileNumber']) || empty($data['mobileNumber'])) {
            return new JsonResponse('Missing mobile number', Response::HTTP_NOT_ACCEPTABLE);
        }

        $user = $this->get('security.user_builder')
            ->make($data['username'], $data['password'], $data['email'], $data['mobileNumber']);

        $this->get('security.orm_user_persister')
            ->store($user);

        $response = new Response(
            $this
                ->container
                ->get('jms_serializer')
                ->serialize($user, 'json'),
            Response::HTTP_CREATED
        );

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}