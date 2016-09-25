<?php

namespace AppBundle\Service\JsonApi\Parser\Request\UserRole;


use AppBundle\Service\JsonApi\Parser\Request\AbstractRequestParser;
use AppBundle\Service\JsonApi\Parser\Request\ValidatedRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class NewUserRoleRequestParser
 * @package AppBundle\Service\JsonApi\Parser\Request\UserRole
 */
class NewUserRoleRequestParser extends AbstractRequestParser
{
    /**
     * @param Request $request
     * @return ValidatedRequest
     */
    public function parse(Request $request)
    {
        $parsedRequest = $this->jrd->deserialize($request);
        $errors = [];

        if (!isset($parsedRequest->data)) {
            $errors['data'][] = 'Missing field';
        } else {
            if (!isset($parsedRequest->data->type)) {
                $errors['data']['type'][] = 'Missing field';
            } else if($parsedRequest->data->type !== 'userRoles') {
                $errors['data']['type'][] = sprintf('Expected userRoles, %s found', $parsedRequest->data->type);
            }

            if (!isset($parsedRequest->data->attributes)) {
                $errors['data']['attributes'][] = 'Missing field';
            } else {
                if (!isset($parsedRequest->data->attributes->role)) {
                    $errors['data']['attributes']['role'][] = 'Missing field';
                } else if (strpos($parsedRequest->data->attributes->role, 'ROLE_') !== 0) {
                    $errors['data']['attributes']['role'][] = 'Must start with ROLE_';
                }
            }

        }

        return new ValidatedRequest($parsedRequest, $errors);
    }
}
