<?php

namespace AppBundle\Service\Validator;


class EmailValidator implements ValidatorInterface
{
    /** @var DomainNameValidator  */
    private $dnv;

    public function __construct(DomainNameValidator $dnv)
    {
        $this->dnv = $dnv;
    }

    /**
     * @param string $email
     * @return array|string[]
     */
    public function validate($email)
    {
        $errors = [];

        $emailTokens = explode('@', $email);
        if (count($emailTokens) !== 2) {
            $errors[] = 'Invalid';
        } else if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid';
        } else if (count($this->dnv->validate($emailTokens[1])) > 0) {
            $errors[] = 'Invalid domain name';
        }

        return $errors;
    }
}