<?php

namespace AppBundle\Service\JsonApi\Validator;


use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class JsonRequestValidator
{
    const JSON_API_ACCEPT_HEADER = 'Accept: application/vnd.api+json';

    public function validate(Request $request)
    {
        if (!$this->assertHeaders($request->headers)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Wrong json API headers');
        }
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