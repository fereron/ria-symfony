<?php

namespace Ria\News\Core\Models\Post;

/**
 *
 * @ORM\Table(name="post_tag")
 */
class Tag
{
    /**
     * @ORM\ManyToOne(targetEntity="Ria\News\Core\Models\Tag\Tag", inversedBy="postAssignments")
     * @ORM\JoinColumn(name="tag_name", referencedColumnName="name")
     */
    private $tag;

    /**
     * @ORM\ManyToOne(targetEntity="Ria\News\Core\Models\Post\Post", inversedBy="tagAssignments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;
}