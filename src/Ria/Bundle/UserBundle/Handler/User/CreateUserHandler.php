<?php
declare(strict_types=1);

namespace Ria\Bundle\UserBundle\Handlers\User;

use Ria\Bundle\UserBundle\Command\User\CreateUserCommand;

/**
 * Class CreateUserHandler
 * @package Ria\Users\Core\Handlers\User
 */
class CreateUserHandler
{
    public function handle(CreateUserCommand $command)
    {
        var_dump($command); exit(0);
    }
}