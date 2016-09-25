<?php

namespace AppBundle\Service\JsonApi\Parser\Request\UserRole;


use AppBundle\Service\JsonApi\Parser\Request\AbstractRequestParser;
use AppBundle\Service\JsonApi\Parser\Request\ValidatedRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DeleteUserRoleRequestParser
 * @package AppBundle\Service\JsonApi\Parser\Request\UserRole
 */
class DeleteUserRoleRequestParser extends AbstractRequestParser
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
