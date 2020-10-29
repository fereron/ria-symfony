<?php

declare(strict_types=1);

namespace Ria\Bundle\PostBundle\Handler\Story;

use Ria\Bundle\PostBundle\Command\Story\CreateStoryCommand;

/**
 * Class CreateStoryHandler
 * @package Ria\Bundle\PostBundle\Handler\Story
 */
class CreateStoryHandler
{
    public function handle(CreateStoryCommand $command)
    {
        dd($command);
    }
}