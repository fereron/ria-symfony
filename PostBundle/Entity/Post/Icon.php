<?php
declare(strict_types=1);

namespace Ria\News\Core\Models\Post;

use InvalidArgumentException;
use Ria\Core\Models\ObjectValue;

/**
 * Class Icon
 * @package Ria\News\Core\Models\Post
 */
class Icon extends ObjectValue
{
    const LIGHTNING = 'lightning';
    const PHOTO = 'camera';
    const VIDEO = 'video-camera';
    const INFOGRAPHICS = 'bar-chart';
    /**
     * @var string
     */
    private $icon;

    /**
     * Type constructor.
     * @param string $icon
     */
    public function __construct(?string $icon = null)
    {
        $this->set($icon);
    }

    /**
     * @param string $icon
     */
    public function set(?string $icon = null): void
    {
        if ($icon && !in_array($icon, self::all())) {
            throw new InvalidArgumentException('Invalid post icon: ' . $icon);
        }

        $this->icon = $icon;
    }

    /**
     * @return array
     */
    public static function all(): array
    {
        return [
            self::LIGHTNING,
            self::VIDEO,
            self::PHOTO,
            self::INFOGRAPHICS,
        ];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->icon ?? '';
    }
}