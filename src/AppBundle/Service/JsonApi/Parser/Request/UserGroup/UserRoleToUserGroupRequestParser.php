<?php

namespace AppBundle\Service\JsonApi\Parser\Request\UserGroup;


use AppBundle\Service\JsonApi\Parser\Request\AbstractRequestParser;
use AppBundle\Service\JsonApi\Parser\Request\ValidatedRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserRoleToUserGroupRequestParser
 * @package AppBundle\Service\JsonApi\Parser\Request\UserGroup
 */
class UserRoleToUserGroupRequestParser extends AbstractRequestParser
{
    public function parse(Request $request)
    {
        $deserializedRequest = $this->jrd->deserialize($request);
        $errors = [];

        if (!isset($deserializedRequest->data)) {
            $errors['data'][] = 'Missing field';
        } else {
            foreach($deserializedRequest->data as $key => $relationship) {
                if (!isset($relationship->type)) {
                    $errors['data'][$key]['type'] = 'Missing field';
                } else if ($relationship->type != 'userRoles'){
                    $errors['data'][$key]['type'] = sprintf('Expected userRoles, %s found', $relationship->type);
                }

                if (!isset($relationship->id)) {
                    $errors['data'][$key]['id'] = 'Missing field';
                } else if (!$relationship->id) {
                    $errors['data'][$key]['id'] = 'Must be a numeric value';
                }
            }
        }

        return new ValidatedRequest($deserializedRequest, $errors);
    }
}