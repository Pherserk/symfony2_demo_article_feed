<?php

namespace AppBundle\Service\Security;


use AppBundle\Entity\ConfirmationToken;

/**
 * Class ConfirmationTokenBuilder
 * @package AppBundle\Service\Security
 */
class ConfirmationTokenBuilder extends AbstractRandomSequenceBuilder
{
    /**
     * @return ConfirmationToken
     */
    public function make()
    {
        return new ConfirmationToken($this->getSequence());
    }
}