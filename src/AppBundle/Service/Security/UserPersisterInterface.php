<?php

namespace AppBundle\Service\Security;


use Symfony\Component\Security\Core\User\UserInterface;

interface UserPersisterInterface
{
    public function store(UserInterface $user);
}