<?php

namespace Ria\Bundle\PostBundle\Entity\Story;

use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="stories")
 * @ORM\Entity(repositoryClass="\Ria\Bundle\PostBundle\Repository\StoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Story
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cover;
    /**
     * @ORM\Column(type="boolean")
     */
    private $status;
    /**
     * @ORM\Column(type="boolean")
     */
    private $show_on_site;
    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Ria\Bundle\PostBundle\Entity\Story\Translation",
     *     mappedBy="story",
     *     cascade={"persist", "remove"},
     *     indexBy="language"
     *     )
     */
    private $translations;

//    /**
//     * @ORM\OneToMany(targetEntity="Ria\News\Core\Models\Post\Post", mappedBy="story", cascade={"persist", "remove"})
//     * @OrderBy({"published_at" = "DESC"})
//     */
//    private $posts;

    /**
     * Story constructor.
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection();
//        $this->posts        = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     * @return Story
     */
    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param string $language
     * @return Translation|false
     */
    public function getTranslation(string $language)
    {
        return $this->translations[$language];
    }

    /**
     * @param Translation $translation
     * @return $this
     */
    public function addTranslation(Translation $translation): self
    {
        if (!$this->getTranslations()->contains($translation)) {
            $this->translations[$translation->getLanguage()] = $translation;
            $translation->setStory($this);
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @return $this
     * @param string $cover
     */
    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @return bool
     */
    public function getShowOnSite(): bool
    {
        return $this->show_on_site;
    }

    /**
     * @param bool $canShowOnSite
     * @return Story
     */
    public function setShowOnSite(bool $canShowOnSite): self
    {
        $this->show_on_site = $canShowOnSite;
        return $this;
    }

}