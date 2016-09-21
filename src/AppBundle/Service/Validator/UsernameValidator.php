<?php

namespace AppBundle\Service\Validator;

/**
 * Class UsernameValidator
 * @package AppBundle\Service\Validator
 */
class UsernameValidator implements ValidatorInterface
{
    /** @var int */
    private $minimumLength;
    /** @var int */
    private $maximumLength;
    /** @var bool */
    private $admitNumbers;
    /** @var bool */
    private $admitSpaces;
    /** @var array|string[] */
    private $admittedSpecialChars;

    /**
     * UsernameValidator constructor.
     * @param $minimumLength
     * @param $maximumLength
     * @param $admitNumbers
     * @param $admitSpaces
     * @param array $admittedSpecialChars
     */
    public function __construct(
        $minimumLength,
        $maximumLength,
        $admitNumbers,
        $admitSpaces,
        array $admittedSpecialChars
    )
    {
        $this->minimumLength = $minimumLength;
        $this->maximumLength = $maximumLength;
        $this->admitNumbers = $admitNumbers;
        $this->admitSpaces = $admitSpaces;
        $this->admittedSpecialChars = $admittedSpecialChars;
    }

    /**
     * @param string $username
     * @return array|string[]
     */
    public function validate($username)
    {
        $errors = [];

        if (mb_strlen($username) < $this->minimumLength) {
            $errors[] = sprintf('Must have a minimum length of %d characters', $this->minimumLength);
        }

        if (mb_strlen($username) > $this->maximumLength) {
            $errors[] = sprintf('Must have a maximum length of %d characters', $this->maximumLength);
        }

        if (!$this->admitNumbers && 1 === preg_match('~[0-9]~', $username)) {
            $errors[] = 'Must not contain numbers';
        }

        if (!$this->admitSpaces && 1 === preg_match('~\s+~', $username)) {
            $errors[] = 'Must not contain spaces';
        }

        return $errors;
    }
}

