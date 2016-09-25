<?php

namespace AppBundle\Service\JsonApi\Parser\Request\UserGroup;


use AppBundle\Service\JsonApi\Parser\Request\AbstractRequestParser;
use AppBundle\Service\JsonApi\Parser\Request\ValidatedRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class NewUserGroupRequestParser
 * @package AppBundle\Service\JsonApi\Parser\Request\UserGroup
 */
class NewUserGroupRequestParser extends AbstractRequestParser
{
    /**
     * @param Request $request
     * @return ValidatedRequest
     */
    public function parse(Request $request)
    {
        $deserializedRequest = $this->jrd->deserialize($request);
        $errors = [];

        if (!isset($deserializedRequest->data)) {
            $errors['data'][] = 'Missing field';
        } else {
            if (!isset($deserializedRequest->data->type)) {
                $errors['data']['type'][] = 'Missing field';
            } else if ($deserializedRequest->data->type !== 'userGroups') {
                $errors['data']['type'][] = sprintf('Expected userGroups, %s found', $deserializedRequest->data->type);
            }

            if (!isset($deserializedRequest->data->attributes)) {
                $errors['data']['attributes'][] = 'Missing field';
            } else if (!isset($deserializedRequest->data->attributes->name)) {
                $errors['data']['attributes']['name'] = 'Missing field';
            } else if (strpos($deserializedRequest->data->attributes->name, 'GROUP_') !== 0) {
                $errors['data']['attributes']['name'] = 'Must start with GROUP_';
            }
        }

        return new ValidatedRequest($deserializedRequest, $errors);
    }
}