<?php

namespace Ria\News\Core\Models\Post;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="post_notes")
 * @ORM\Entity
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $body;

    /**
     * @ORM\Column(type="integer")
     */
    private $post_group_id;

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Note
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param int $post_group_id
     * @return $this
     */
    public function setPostGroupId(int $post_group_id)
    {
        $this->post_group_id = $post_group_id;

        return $this;
    }

}