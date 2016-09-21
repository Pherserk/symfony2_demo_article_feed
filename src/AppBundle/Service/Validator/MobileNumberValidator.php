<?php

namespace AppBundle\Service\Validator;


class MobileNumberValidator implements ValidatorInterface
{
    /**
     * @param string $mobileNumber
     * @return array|string[]
     */
    public function validate($mobileNumber)
    {
        $errors = [];

        if (preg_match('/^\+/', $mobileNumber) === 0) {
            $errors[] = 'Must start with + sign';
        } else if (preg_match('/^\+([0-9])+$/', $mobileNumber) === 0) {
            $errors[] = 'Contains invalid characters, after + sign only numbers allowed';
        }

        return $errors;
    }
}