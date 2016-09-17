<?php

namespace AppBundle\Service\Validator;

/**
 * Class PlainPasswordValidator
 * @package AppBundle\Service\Validator
 */
class PlainPasswordValidator implements ValidatorInterface
{
    /** @var int */
    private $minimumLength;

    /** @var int */
    private $maximumLength;

    /** @var int */
    private $minimumSpecialCharsCount;

    /** @var int */
    private $minimumNumbersCount;

    /** @var int */
    private $minimumUppercaseCharsCount;

    /** @var int */
    private $minimumLowercaseCharsCount;

    /** @var array|string[] */
    private $admittedSpecialChars;

    /**
     * PlainPasswordValidator constructor.
     * @param int $minimumLength
     * @param int $maximumLength
     * @param int int $minimumSpecialCharsCount
     * @param int $minimumNumbersCount
     * @param int $minimumUppercaseCharsCount
     * @param int $minimumLowercaseCharsCount
     * @param array|string[] $admittedSpecialChars
     */
    public function __construct(
        $minimumLength,
        $maximumLength,
        $minimumNumbersCount,
        $minimumUppercaseCharsCount,
        $minimumLowercaseCharsCount,
        $minimumSpecialCharsCount,
        array $admittedSpecialChars
    )
    {
        $this->minimumLength = $minimumLength;
        $this->maximumLength = $maximumLength;
        $this->minimumNumbersCount = $minimumNumbersCount;
        $this->minimumUppercaseCharsCount = $minimumUppercaseCharsCount;
        $this->minimumLowercaseCharsCount = $minimumLowercaseCharsCount;
        $this->minimumSpecialCharsCount = $minimumSpecialCharsCount;
        $this->admittedSpecialChars = $admittedSpecialChars;
    }

    /**
     * @param string $plainPassword
     * @return array
     */
    public function validate($plainPassword)
    {
        $errors = [];

        if (strlen($plainPassword) < $this->minimumLength) {
            $errors[] = sprintf('Must have a minimum length of %d characters', $this->minimumLength);
        }

        if (strlen($plainPassword) > $this->maximumLength) {
            $errors[] = sprintf('Must have a maximum length of %d characters', $this->maximumLength);
        }

        if (!$this->minimumNumbersCount >= preg_match('~[0-9]~', $plainPassword)) {
            $errors[] = sprintf('Must contain at least %d number%s', $this->minimumNumbersCount, $this->minimumNumbersCount>1?'s':'');
        }

        if (!$this->minimumLowercaseCharsCount >= preg_match('~[a-z]~', $plainPassword)) {
            $errors[] = sprintf('Must contain at least %d lowercase letter%s', $this->minimumLowercaseCharsCount, $this->minimumLowercaseCharsCount>1?'s':'');
        }

        if (!$this->minimumUppercaseCharsCount >= preg_match('~[A-Z]~', $plainPassword)) {
            $errors[] = sprintf('Must contain at least %d uppercase letter%s', $this->minimumUppercaseCharsCount, $this->minimumUppercaseCharsCount>1?'s':'');
        }

        return $errors;
    }
}