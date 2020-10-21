<?php
declare(strict_types=1);

namespace Ria\News\Core\Models\Post;

use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="post_notifications")
 * @ORM\Entity
 */
class Notification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Ria\News\Core\Models\Post\Post", inversedBy="notifications")
     * @JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;


    /**
     * @param int $status
     * @return Notification
     */
    public function setStatus(int $status)
    {
        $this->status = $status;

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

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $created_at
     * @return Notification
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

}