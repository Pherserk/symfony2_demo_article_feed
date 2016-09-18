<?php

namespace AppBundle\Service\JsonApi\Parser\Request;



use AppBundle\Service\JsonApi\Deserializer\JsonRequestDeserializer;
use Symfony\Component\HttpFoundation\Request;

class AddUserRoleToUserGroupRequestParser extends AbstractRequestParser
{
    /**
     * AddUserRoleToUserGroupRequestParser constructor.
     * @param JsonRequestDeserializer $jrd
     */
    public function __construct(JsonRequestDeserializer $jrd)
    {
        parent::__construct($jrd);
    }

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