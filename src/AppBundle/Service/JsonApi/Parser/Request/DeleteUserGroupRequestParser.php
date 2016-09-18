<?php

namespace AppBundle\Service\JsonApi\Parser\Request;


use AppBundle\Service\JsonApi\Deserializer\JsonRequestDeserializer;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DeleteUserGroupRequestParser
 * @package AppBundle\Service\JsonApi\Parser\Request
 */
class DeleteUserGroupRequestParser extends AbstractRequestParser
{
    /**
     * DeleteUserGroupRequestParser constructor.
     * @param JsonRequestDeserializer $jrd
     */
    public function __construct(JsonRequestDeserializer $jrd)
    {
        parent::__construct($jrd);
    }

    /**
     * @param Request $request
     * @return ValidatedRequest
     */
    public function parse(Request $request)
    {
        $data = $this->jrd->deserialize($request);
        $errors = [];

        return new ValidatedRequest($data, $errors);
    }
}