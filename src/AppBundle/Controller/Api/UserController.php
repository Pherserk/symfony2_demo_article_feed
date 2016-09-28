<?php

namespace AppBundle\Controller\Api;


use AppBundle\Entity\UserGroup;
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
        $this->get('json_api.validator.json_request_validator')
            ->validate($request);
        
        $parsedRequest = $this->get('json_api.parser.request.new_user')
            ->parse($request);

        $data = $parsedRequest->getData();

        if (!$parsedRequest->isPassed()) {
            return new JsonResponse($parsedRequest->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        $user = $this->get('security.user_builder')
            ->make(
                $data->data->attributes->username,
                $data->data->attributes->password,
                $data->data->attributes->email,
                $data->data->attributes->mobileNumber
            );

        $userGroup = $this->getDoctrine()
            ->getManager()
            ->getRepository(UserGroup::class)
            ->findOneBy(['name' => 'GROUP_USER']);

        $user->addGroup($userGroup);

        $this->get('security.orm_user_persister')
            ->store($user);

        return $this->get('json_api.response.json_api_response_builder')
            ->make(
                $user,
                'users',
                Response::HTTP_CREATED
            );
    }

    /**
     * @Route("/confirmEmail", options={"expose"=true})
     * @Method("POST")
     * @Security("is_granted('ROLE_USER')")
     */
    public function confirmEmailCommandAction(Request $request)
    {
        $parsedRequest = $this->get('json_rpc.parser.request.confirm_email')
            ->parse($request);
    }

    /**
     * @Route("/confirmMobileNumber", options={"expose"=true})
     * @Method("POST")
     * @Security("is_granted('ROLE_USER')")
     */
    public function confirmMobileNumberCommandAction(Request $request)
    {
        $parsedRequest = $this->get('json_rpc.parser.request.confirm_mobile_number')
            ->parse($request);
    }
}
