<?php

namespace AppBundle\Service\Validator;

/**
 * Class DomainNameValidator
 * @package AppBundle\Service\Validator
 */
class DomainNameValidator implements ValidatorInterface
{
    /**
     * @param string $domainName
     * @return array|string[]
     */
    public function validate($domainName)
    {
        $errors = [];

        $domainNameTokens = explode('.', $domainName);

        if (count($domainNameTokens) < 2) {
            $errors[] = 'Invalid';
        }

        $tldTokens = array_slice($domainNameTokens, 1);

        foreach ($tldTokens as $tldToken) {
            if (mb_strlen($tldToken) < 2) {
                $errors[] = sprintf('Invalid tld %s', implode('.', $tldTokens));
                break;
            }
        }

        return $errors;
    }
}