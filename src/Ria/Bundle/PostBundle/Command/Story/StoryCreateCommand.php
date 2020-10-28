<?php
declare(strict_types=1);

namespace Ria\Bundle\PostBundle\Command\Story;

use Symfony\Component\Validator\Constraints as Assert;

class StoryCreateCommand
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    public string $title;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    public string $slug;

}