<?php

namespace AppBundle\Service\JsonApi\Parser\Request;


use Symfony\Component\HttpFoundation\Request;

/**
 * Class DeleteUserRoleRequestParser
 * @package AppBundle\Service\JsonApi\Parser\Request
 */
class DeleteUserRoleRequestParser extends AbstractRequestParser
{
    /**
     * @param Request $request
     * @return ValidatedRequest
     */
    public function parse(Request $request)
    {
        $data = $this->jrd->deserialize($request, true);
        $errors = [];

        return new ValidatedRequest($data, $errors);
    }
}
