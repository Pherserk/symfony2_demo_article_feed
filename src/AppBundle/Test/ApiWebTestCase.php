<?php

namespace AppBundle\Test;


use AppBundle\Service\JsonApi\Validator\JsonRequestValidator;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class ApiWebTestCase extends WebTestCase
{
    protected function getAuthorizedHeaders($username, &$headers = [])
    {
        $token = $this->getContainer()
            ->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => $username]);

        # FIXME browserkit internal bug
        $headers['HTTP_Authorization'] = 'Bearer '.$token;
    }

    protected function getJsonApiAcceptdHeaders(&$headers = [])
    {
        $headers['CONTENT_TYPE'] = JsonRequestValidator::APPLICATION_JSON_API_CONTENT_IANA;
        # FIXME browserkit internal bug
        $headers['HTTP_Accept'] = JsonRequestValidator::APPLICATION_JSON_API_CONTENT_IANA;
    }
}
