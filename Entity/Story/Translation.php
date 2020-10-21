<?php

namespace Ria\News\Core\Models\Story;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Ria\Core\Models\Meta;
use Ria\News\Core\Models\Story\Traits\TranslationLifecycleCallbacks;

/**
 * @ORM\Table(name="stories_lang", uniqueConstraints={@UniqueConstraint(name="slug", columns={"slug", "language"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Translation
{
    use TranslationLifecycleCallbacks;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $slug;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
    public $language;

    /**
     * @ORM\Column(type="text")
     */
    private $meta;

    /**
     * @ORM\ManyToOne(targetEntity="\Ria\News\Core\Models\Story\Story", inversedBy="translations")
     * @JoinColumn(name="story_id", referencedColumnName="id")
     */
    private $story;

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return $this
     */
    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param Story $story
     * @return $this
     */
    public function setStory(Story $story): self
    {
        $this->story = $story;

        return $this;
    }

    /**
     * @param Meta $meta
     * @return $this
     */
    public function setMeta(Meta $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * @return Meta
     */
    public function getMeta(): Meta
    {
        return $this->meta;
    }

}