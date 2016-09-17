<?php

namespace AppBundle\Service\Security;


use AppBundle\Entity\ConfirmationPin;

/**
 * Class ConfirmationPinBuilder
 * @package AppBundle\Service\Security
 */
class ConfirmationPinBuilder extends AbstractRandomSequenceBuilder
{
    /**
     * @return ConfirmationPin
     */
    public function make()
    {
        return new ConfirmationPin($this->getSequence());
    }
}