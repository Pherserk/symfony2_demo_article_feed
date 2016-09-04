<?php

namespace AppBundle\Test;


use Liip\FunctionalTestBundle\Test\WebTestCase;

class ApiWebTestCase extends WebTestCase
{
    protected function getAuthorizedHeaders($username, $headers = array())
    {
        $token = $this->getContainer()
            ->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => $username]);

        # FIXME browserkit internal bug
        $headers['HTTP_Authorization'] = 'Bearer '.$token;
        
        return $headers;
    }
}