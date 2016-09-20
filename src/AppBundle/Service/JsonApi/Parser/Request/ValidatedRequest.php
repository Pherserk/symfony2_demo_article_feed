<?php

namespace AppBundle\Service\JsonApi\Parser\Request;

/**
 * Class ValidatedRequest
 * @package AppBundle\Service\JsonApi\Validator\Request
 */
class ValidatedRequest
{
    /** @var array  */

    private $data;

    /** @var array|string[] */
    private $errors;

    /** @var bool */
    private $passed;

    /**
     * RequestValidation constructor.
     * @param array $data
     * @param array $errors
     */
    public function __construct($data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * @return array|object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array|\string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function isPassed()
    {
        return count($this->errors) === 0;
    }
}



