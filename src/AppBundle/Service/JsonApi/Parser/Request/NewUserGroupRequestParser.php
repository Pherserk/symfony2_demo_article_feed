<?php

namespace AppBundle\Service\JsonApi\Parser\Request;


use AppBundle\Service\JsonApi\Deserializer\JsonRequestDeserializer;
use Symfony\Component\HttpFoundation\Request;

class NewUserGroupRequestParser extends AbstractRequestParser
{
    /**
     * NewUserGroupRequestParser constructor.
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

        if (!isset($data['name'])) {
            $errors['name'][] = 'Missing field';
        } else if (strpos($data['name'], 'GROUP_') !== 0) {
            $errors['name'][] = 'Must start with GROUP_';
        }

        return new ValidatedRequest($data, $errors);
    }
}