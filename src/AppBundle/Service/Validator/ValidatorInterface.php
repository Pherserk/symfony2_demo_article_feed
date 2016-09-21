<?php

namespace AppBundle\Service\Validator;


interface ValidatorInterface
{
    /**
     * @param mixed $value
     * @return array|string[]
     */
    public function validate($value);
}