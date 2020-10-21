<?php
declare(strict_types=1);

namespace Ria\News\Core\Models\Post;

use InvalidArgumentException;
use Ria\Core\Models\ObjectValue;

/**
 * Class Type
 * @package Ria\News\Core\Models\Post
 */
class Type extends ObjectValue
{
    const POST        = 'post';
    const PHOTO       = 'photo';
    const VIDEO       = 'video';
    const ARTICLE     = 'article';
    const INFOGRAPHIC = 'infographic';
    const OPINION     = 'opinion';
    const PARTNERS    = 'partners';
    /**
     * @var string
     */
    private $type;

    /**
     * Type constructor.
     * @param string $type
     */
    public function __construct(string $type)
    {
        if (!in_array($type, self::all())) {
            throw new InvalidArgumentException('Invalid post type: ' . $type);
        }

        $this->type = $type;
    }

    /**
     * @return array
     */
    public static function all(): array
    {
        return [
            self::POST,
            self::ARTICLE,
            self::VIDEO,
            self::PHOTO,
            self::INFOGRAPHIC,
            self::OPINION,
            self::PARTNERS
        ];
    }

    /**
     * @return array
     */
    public static function media(): array
    {
        return [self::VIDEO, self::PHOTO, self::INFOGRAPHIC];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isVideo(): bool
    {
        return $this->type == self::VIDEO;
    }

    /**
     * @return bool
     */
    public function isPhoto(): bool
    {
        return $this->type == self::PHOTO;
    }
}