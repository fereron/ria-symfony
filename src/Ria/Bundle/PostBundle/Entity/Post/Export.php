<?php
declare(strict_types=1);

namespace Ria\News\Core\Models\Post;

use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="post_exports")
 * @ORM\Entity
 */
class Export
{
    const COMMON             = 'common';
    const YANDEX_DZEN        = 'yandex_dzen';
    const PUSH_NOTIFICATIONS = 'push_notifications';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Ria\News\Core\Models\Post\Post", inversedBy="exports")
     * @JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * @return array
     */
    public static function all(): array
    {
        return [
            self::COMMON,
            self::YANDEX_DZEN,
            self::PUSH_NOTIFICATIONS
        ];
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return bool
     */
    public function is(string $type): bool
    {
        return $this->type === $type;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $type
     * @return Export
     */
    public function setType(string $type)
    {
        if (in_array($type, self::all())) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * @param $post
     * @return $this
     */
    public function setPost($post): self
    {
        $this->post = $post;

        return $this;
    }

}