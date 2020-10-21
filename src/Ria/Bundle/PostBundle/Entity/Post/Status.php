<?php
declare(strict_types=1);

namespace Ria\News\Core\Models\Post;

use Core\Helpers\StatusHelper;
use InvalidArgumentException;
use Ria\Core\Models\ObjectValue;

/**
 * Class Status
 * @package Ria\News\Core\Models\Post
 */
class Status extends ObjectValue
{
    public const CREATED                = 'created';
    public const ON_MODERATION          = 'on_moderation';
    public const WAITING_FOR_CORRECTION = 'waiting_for_correction';
    public const READ                   = 'read';
    public const DELETED                = 'deleted';
    public const ARCHIVED               = 'archived';
    public const PRIVATE                = 'private';

    /**
     * @var string
     */
    private $status;

    /**
     * Status constructor.
     * @param string $status
     */
    public function __construct(string $status)
    {
        if (!in_array($status, self::all())) {
            throw new InvalidArgumentException('Invalid post status: ' . $status);
        }

        $this->status = $status;
    }

    /**
     * @return array
     */
    public static function all(): array
    {
        return [
            self::READ,
            self::CREATED,
            self::ON_MODERATION,
            self::WAITING_FOR_CORRECTION,
            self::PRIVATE,
            self::ARCHIVED,
            self::DELETED
        ];
    }

    /**
     * @return array
     */
    public static function list(): array
    {
        return [
            self::CREATED,
            self::ON_MODERATION,
            self::WAITING_FOR_CORRECTION,
            self::READ,
            self::PRIVATE,
            self::ARCHIVED
        ];
    }

    /**
     * @return array
     */
    public static function activeOnes(): array
    {
        return [
            self::CREATED,
            self::ON_MODERATION,
            self::WAITING_FOR_CORRECTION,
            self::READ,
            self::PRIVATE
        ];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->status;
    }

    /**
     * @param $status
     * @return bool
     */
    public function is($status): bool
    {
        return $this->status == $status;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return StatusHelper::isActive($this->status);
    }

    /**
     * @return bool
     */
    public function isPrivate(): bool
    {
        return $this->status == self::PRIVATE;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->status === self::DELETED;
    }

    /**
     * @return bool
     */
    public function isModerated(): bool
    {
        return $this->status === self::ON_MODERATION;
    }

}