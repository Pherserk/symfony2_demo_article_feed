<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\UserRole;
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
 * @Route("/api/user-roles")
 */
class UserRoleController extends Controller
{
    /**
     * @Route("", options={"expose"=true})
     * @Method("POST")
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $parsedRequest = $this->get('json_api.parser.request.new_user_role')
            ->parse($request);

        $data = $parsedRequest->getData();

        if (!$parsedRequest->isPassed()) {
            return new JsonResponse($parsedRequest->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        $userRole = new UserRole($data['role']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($userRole);
        $em->flush($userRole);
        
        $response = new Response(
            $this->get('jms_serializer')
                ->serialize($userRole, 'json'),
            Response::HTTP_CREATED
        );

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/{userRole}", options={"expose"=true})
     * @Method("DELETE")
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function deleteAction(Request $request, UserRole $userRole)
    {
        $parsedRequest = $this->get('json.api.parser.request.delete_user_role')
            ->parse($request);

        $data = $parsedRequest->getData();

        if (!$parsedRequest->isPassed()) {
            return new JsonResponse($parsedRequest->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($userRole);
        $em->flush($userRole);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
