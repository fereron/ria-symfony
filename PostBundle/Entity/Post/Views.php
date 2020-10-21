<?php

namespace Ria\News\Core\Models\Post;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="post_views")
 * @ORM\Entity
 */
class Views
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $views;

    /**
     * @ORM\Column(type="integer")
     */
    private $post_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;
}