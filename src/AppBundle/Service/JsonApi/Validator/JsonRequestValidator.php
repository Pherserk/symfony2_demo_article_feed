<?php

namespace AppBundle\Service\JsonApi\Validator;


use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;

class JsonRequestValidator
{
    const JSON_API_ACCEPT_HEADER = 'Accept: application/vnd.api+json';

    public function validate(Request $request)
    {
        $this->assertHeaders($request->headers);
    }

    public function assertHeaders(HeaderBag $headers)
    {
        $acceptHeaders = $headers->get('Accept');

        if (is_array($acceptHeaders)) {
            return in_array(self::JSON_API_ACCEPT_HEADER, $acceptHeaders, true);
        }

        return self::JSON_API_ACCEPT_HEADER === $acceptHeaders;
    }
}