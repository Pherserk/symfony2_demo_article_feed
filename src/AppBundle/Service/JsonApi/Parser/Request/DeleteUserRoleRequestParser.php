<?php

namespace AppBundle\Service\JsonApi\Parser\Request;


use AppBundle\Service\JsonApi\Deserializer\JsonRequestDeserializer;
use Symfony\Component\HttpFoundation\Request;

class DeleteUserRoleRequestParser extends AbstractRequestParser
{
    /**
     * NewUserRoleRequestParser constructor.
     * @param JsonRequestDeserializer $jrd
     */
    public function __construct(JsonRequestDeserializer $jrd)
    {
        parent::__construct($jrd);
    }

    public function parse(Request $request)
    {
        $data = $this->jrd->deserialize($request);
        $errors = [];

        return new ValidatedRequest($data, $errors);
    }
}