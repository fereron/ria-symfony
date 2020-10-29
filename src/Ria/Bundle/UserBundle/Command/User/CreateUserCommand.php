<?php

declare(strict_types=1);

namespace Ria\Bundle\UserBundle\Command\User;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateUserCommand
 * @package Ria\Bundle\UserBundle\Command\User
 */
class CreateUserCommand
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=100)
     */
    private string $email;
}