<?php

namespace Ria\News\Core\Models\Post;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Sortable\Entity\Repository\SortableRepository")
 * @ORM\Table(name="post_photo")
 */
class Photo
{
    /**
     * @ORM\ManyToOne(targetEntity="Ria\Photos\Core\Models\Photo\Photo", inversedBy="postAssignments")
     * @ORM\JoinColumn(name="photo_id", referencedColumnName="id")
     * @ORM\Id()
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity="Ria\News\Core\Models\Post\Post", inversedBy="photoRelations")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * @ORM\Id()
     */
    private $post;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     * @return Photo
     */
    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     * @return Photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @param mixed $sort
     * @return Photo
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }
}