<?php

namespace AppBundle\Service\JsonApi\Parser\Request;


use Symfony\Component\HttpFoundation\Request;

/**
 * Class DeleteUserGroupRequestParser
 * @package AppBundle\Service\JsonApi\Parser\Request
 */
class DeleteUserGroupRequestParser extends AbstractRequestParser
{
    /**
     * @param Request $request
     * @return ValidatedRequest
     */
    public function parse(Request $request)
    {
        $parsedRequest = $this->jrd->deserialize($request);
        $errors = [];

        return new ValidatedRequest($parsedRequest, $errors);
    }
}