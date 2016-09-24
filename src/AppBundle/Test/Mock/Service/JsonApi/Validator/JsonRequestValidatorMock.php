<?php

namespace AppBundle\Test\Mock\Service\JsonApi\Validator;


use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class JsonRequestValidatorMock
{
    const APPLICATION_JSON_API_CONTENT_IANA = 'application/vnd.api+json';

    public function validate(Request $request)
    {
        $this->assertHeaders($request->headers);
    }

    public function assertHeaders(HeaderBag $headers)
    {
        $acceptHeaders = $headers->get('Accept');

        if (is_array($acceptHeaders)) {
            $acceptHeadersPassed = in_array(self::APPLICATION_JSON_API_CONTENT_IANA, $acceptHeaders, true);
        } else {
            $acceptHeadersPassed = (self::APPLICATION_JSON_API_CONTENT_IANA === $acceptHeaders);
        }

        $contentTypeHeaders = $headers->get('Content-Type');
        if (is_array($contentTypeHeaders)) {
            $contentTypeHeadersPassed = in_array(self::APPLICATION_JSON_API_CONTENT_IANA, $contentTypeHeaders, true);
        } else {
            $contentTypeHeadersPassed = (self::APPLICATION_JSON_API_CONTENT_IANA === $contentTypeHeaders);
        }

        if (!$acceptHeadersPassed /*|| !$contentTypeHeadersPassed*/) {
            $message = $acceptHeadersPassed ? '' : 'Missing Accept Header';
            $message .= $contentTypeHeadersPassed ? ($message !== '') ? ' ' : '' : 'Missing Content-Type Header';

            throw new HttpException(Response::HTTP_BAD_REQUEST, $message);
        }
    }
}
