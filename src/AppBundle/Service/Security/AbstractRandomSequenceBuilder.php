<?php

namespace AppBundle\Service\Security;

/**
 * Class AbstractRandomSequenceBuilder
 * @package AppBundle\Service\Security
 */
abstract class AbstractRandomSequenceBuilder
{
    /** @var string $alphabet */
    private $alphabet;

    /** @var int $length */
    private $length;

    /** @var string $sequence */
    private $sequence;

    /**
     * AbstractRandomSequenceBuilder constructor.
     * @param string $alphabet
     * @param int $length
     */
    public function __construct($alphabet, $length)
    {
        $this->alphabet = $alphabet;
        $this->length = $length;

        $this->sequence = '';
        while (strlen($this->sequence) < $this->length) {
            $this->sequence .= substr($this->alphabet, mt_rand(0, strlen($this->alphabet)), 1);
        }
    }

    /**
     * @return string
     */
    protected function getSequence()
    {
        return $this->sequence;
    }
}