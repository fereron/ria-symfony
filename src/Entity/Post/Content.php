<?php
declare(strict_types=1);

namespace Ria\News\Core\Models\Post;

use Ria\Core\Models\ObjectValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Content
 * @package Ria\News\Core\Models\Post
 *
 * @ORM\Embeddable()
 */
class Content extends ObjectValue
{
    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * Content constructor.
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function withoutTokens(): string
    {
        $content = strip_tags($this->content);
        $content = preg_replace('/({{widget-content-\d+}})/i', '', $content);
        $content = str_replace('{{gallery}}', '', $content);
        $content = preg_replace('/{{gallery_\d+}}/', '', $content);
        $content = preg_replace('/({{expert-quote-\d+}})/i', '', $content);
        return preg_replace('/({{photo-(small-left|small-right|big)-\d+}})/i', '', $content);
    }

}