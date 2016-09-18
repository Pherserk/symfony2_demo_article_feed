<?php

namespace AppBundle\Service\JsonApi\Parser\Request;


use AppBundle\Service\JsonApi\Deserializer\JsonRequestDeserializer;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class NewUserRoleRequestParser
 * @package AppBundle\Service\JsonApi\Parser\Request
 */
class NewUserRoleRequestParser extends AbstractRequestParser
{

    /**
     * NewUserRoleRequestParser constructor.
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
        $data = $this->jrd->deserialize($request, true);
        $errors = [];

        if (!isset($data['role'])) {
            $errors['role'][] = 'Missing field';
        } else if (strpos($data['role'], 'ROLE_') !== 0) {
            $errors['role'][] = 'Must start with ROLE_';
        }

        return new ValidatedRequest($data, $errors);
    }
}