<?php
declare(strict_types=1);

namespace Ria\Bundle\PostBundle\Handler;

use Ria\Bundle\PostBundle\Command\Story\StoryCreateCommand;

class StoryHandler
{

    public function handle(StoryCreateCommand $command)
    {

        dd('handled story command', $command);
    }

}