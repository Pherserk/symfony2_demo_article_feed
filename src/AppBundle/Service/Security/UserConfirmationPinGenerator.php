<?php

namespace AppBundle\Service\Security;


class UserConfirmationPinGenerator
{
    /** @var string $alphabet */
    private $alphabet;

    /** @var int $length */
    private $length;

    /**
     * UserConfirmationPinGenerator constructor.
     * @param string $alphabet
     * @param int $length
     */
    public function __construct($alphabet, $length)
    {
        $this->alphabet = $alphabet;
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function generate()
    {
        $pin = '';
        while (strlen($pin) < $this->length) {
            $pin .= substr($this->alphabet, mt_rand(0, strlen($this->alphabet)), 1);
        }

        return $pin;
    }
}