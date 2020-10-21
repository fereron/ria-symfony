<?php
declare(strict_types=1);

namespace Ria\News\Core\Models\Post;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ria\Core\Models\Entity;
use Ria\Core\Models\Meta;
use Ria\Core\Models\RelationsTrait;
use Ria\News\Core\Models\Category\Category;
use Ria\News\Core\Models\Post\Traits\LifecycleCallbacks;
use Ria\News\Core\Models\Post\Traits\Logs;
use Ria\News\Core\Models\Post\Traits\Persons;
use Ria\News\Core\Models\Post\Traits\Photos;
use Ria\News\Core\Models\Post\Traits\Related;
use Ria\News\Core\Models\Post\Traits\Tags;
use Ria\News\Core\Models\Post\Traits\Translations;
use Ria\News\Core\Models\Story\Story;
use Ria\Photos\Core\Models\HasPhotosInterface;
use Ria\Users\Core\Models\User;
use Ria\News\Core\Models\Post\Traits\Exports;
use Ria\News\Core\Models\Post\Traits\Notifications;
use Ria\News\Core\Models\City\City;

/**
 *
 * @ORM\Table(name="posts",uniqueConstraints={@ORM\UniqueConstraint(name="slug_unique", columns={"slug", "language"})})
 * @ORM\Entity(repositoryClass="Ria\News\Core\Query\Repositories\PostsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Post extends Entity implements HasPhotosInterface
{
    use Exports;
    use Notifications;
    use LifecycleCallbacks;
    use Photos;
    use Related;
    use RelationsTrait;
    use Tags;
    use Persons;
    use Translations;
    use Logs;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $group_id;
    /**
     * @ORM\Column(type="string")
     */
    private $type;
    /**
     * @ORM\Column(type="integer", )
     */
    private $views = 0;
    /**
     * @ORM\Column(type="string")
     */
    private $icon;
    /**
     * @ORM\Column(type="string")
     */
    private $youtube_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $created_by;
    /**
     * @ORM\Column(type="string")
     */
    private $option_type;
    /**
     * @ORM\Column(type="string")
     */
    private $language;
    /**
     * @ORM\Column(type="string")
     */
    private $title;
    /**
     * @ORM\Column(type="string")
     */
    private $description;
    /**
     * @ORM\Embedded(class="Ria\News\Core\Models\Post\Content", columnPrefix=false)
     * @var Content
     */
    private $content;
    /**
     * @ORM\Column(type="string")
     */
    private $source;
    /**
     * @ORM\Column(type="datetime")
     */
    private $published_at;
    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;
    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;
    /**
     * @ORM\Column(type="string")
     */
    private $slug;
    /**
     * @ORM\Column(type="string")
     */
    private $status;
    /**
     * @ORM\Column(type="string")
     */
    private $image;
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_published = false;
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_main;
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_exclusive;
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_actual;
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_breaking;
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_important;
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_deactivated;
    /**
     * @ORM\Column(type="text")
     */
    private $meta;
    /**
     * @ORM\Column(type="boolean")
     */
    private $links_noindex;
    /**
     * @ORM\ManyToOne(targetEntity="Ria\News\Core\Models\Category\Category", inversedBy="posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    /**
     * @ORM\ManyToOne(targetEntity="Ria\News\Core\Models\Story\Story", inversedBy="posts")
     * @ORM\JoinColumn(name="story_id", referencedColumnName="id")
     */
    private $story;
    /**
     * @ORM\ManyToOne(targetEntity="Ria\Users\Core\Models\User", inversedBy="posts")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="Ria\Users\Core\Models\User", inversedBy="posts")
     * @ORM\JoinColumn(name="translator_id", referencedColumnName="id")
     */
    private $translator;

    /**
     * @ORM\ManyToOne(targetEntity="Ria\Persons\Core\Models\Person", inversedBy="posts")
     * @ORM\JoinColumn(name="expert_id", referencedColumnName="id")
     */
    private $expert;
    /**
     * @ORM\ManyToOne(targetEntity="Ria\News\Core\Models\City\City", inversedBy="posts")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $marked_words;

    /**
     * @ORM\OneToMany(
     *     targetEntity="\Ria\News\Core\Models\Person\PersonPost",
     *     mappedBy="post",
     *     cascade={"persist", "remove"},
     *     indexBy="person"
     *     )
     */
    private $post_person;


    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->related         = new ArrayCollection();
        $this->tags            = new ArrayCollection();
        $this->exports         = new ArrayCollection();
        $this->persons         = new ArrayCollection();
        $this->translations    = new ArrayCollection();
        $this->photo_relations = new ArrayCollection();
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Icon
     */
    public function getIcon(): Icon
    {
        return $this->icon;
    }

    /**
     * @return string|null
     */
    public function getYoutubeId(): ?string
    {
        return $this->youtube_id;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getMarkedWords(): array
    {
        return $this->marked_words;
    }

    /**
     * @param array $words
     * @return string
     */
    public function setMarkedWords(array $words)
    {
        $this->marked_words = $words;
        return $this;
    }

    /**
     * @return Content
     */
    public function getContent(): Content
    {
        return $this->content;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @return DateTime
     */
    public function getPublishedAt(): DateTime
    {
        return $this->published_at;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return Meta
     */
    public function getMeta(): Meta
    {
        return $this->meta;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return Story
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * @param $story
     * @return Post
     */
    public function setStory($story): self
    {
        $this->story = $story;
        return $this;
    }

    /**
     * @param mixed $type
     * @return Post
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param mixed $icon
     * @return Post
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @param string|null $youtubeId
     * @return Post
     */
    public function setYoutubeId(?string $youtubeId)
    {
        $this->youtube_id = $youtubeId;
        return $this;
    }

    /**
     * @param mixed $category
     * @return Post
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @param mixed $language
     * @return Post
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @param mixed $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param mixed $description
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param Content $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param mixed $source
     * @return Post
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @param mixed $publishedAt
     * @return Post
     */
    public function setPublishedAt($publishedAt)
    {
        $this->published_at = $publishedAt;
        return $this;
    }

    /**
     * @param mixed $slug
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @param Status $status
     * @return Post
     */
    public function setStatus(Status $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param mixed $meta
     * @return Post
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param mixed $created_by
     * @return Post
     */
    public function setCreatedBy(int $created_by)
    {
        $this->created_by = $created_by;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @param mixed $group_id
     * @return Post
     */
    public function setGroupId(?int $group_id)
    {
        $this->group_id = $group_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsMain()
    {
        return $this->is_main;
    }

    /**
     * @return mixed
     */
    public function getIsActual()
    {
        return $this->is_actual;
    }

    /**
     * @param bool $is_main
     * @return Post
     */
    public function setIsMain(bool $is_main): self
    {
        $this->is_main = $is_main;
        return $this;
    }

    /**
     * @param bool $is_exclusive
     * @return $this
     */
    public function setIsExclusive(bool $is_exclusive): self
    {
        $this->is_exclusive = $is_exclusive;
        return $this;
    }

    /**
     * @param bool $is_actual
     * @return $this
     */
    public function setIsActual(bool $is_actual): self
    {
        $this->is_actual = $is_actual;
        return $this;
    }

    /**
     * @param bool $is_breaking
     * @return $this
     */
    public function setIsBreaking(bool $is_breaking): self
    {
        $this->is_breaking = $is_breaking;
        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @return City|null
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * @param $author
     * @return $this
     */
    public function setAuthor($author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @param City|object|null $city
     * @return $this
     */
    public function setCity($city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getTranslator(): ?User
    {
        return $this->translator;
    }

    /**
     * @param $translator
     * @return $this
     */
    public function setTranslator($translator): self
    {
        $this->translator = $translator;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOptionType(): ?string
    {
        return $this->option_type;
    }

    /**
     * @param mixed $option_type
     * @return Post
     */
    public function setOptionType(?string $option_type): self
    {
        $this->option_type = $option_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsBreaking()
    {
        return $this->is_breaking;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->is_published;
    }

    /**
     * @param bool $is_published
     * @return Post
     */
    public function setIsPublished(bool $is_published): self
    {
        $this->is_published = $is_published;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return Post
     */
    public function setImage(?string $image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param int $views
     * @return Post
     */
    public function setViews(int $views)
    {
        $this->views = $views;
        return $this;
    }

    /**
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * @return mixed
     */
    public function getIsExclusive()
    {
        return $this->is_exclusive;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return bool
     */
    public function getIsImportant(): bool
    {
        return $this->is_important;
    }

    /**
     * @param bool $isImportant
     * @return $this
     */
    public function setIsImportant(bool $isImportant): self
    {
        $this->is_important = $isImportant;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpert()
    {
        return $this->expert;
    }

    /**
     * @param mixed $expert
     * @return Post
     */
    public function setExpert($expert)
    {
        $this->expert = $expert;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isDeactivated()
    {
        return $this->is_deactivated == true;
    }

    /**
     * @param mixed $is_deactivated
     * @return Post
     */
    public function setIsDeactivated($is_deactivated)
    {
        $this->is_deactivated = $is_deactivated;
        return $this;
    }

    /**
     * @return bool
     */
    public function getLinksNoindex(): bool
    {
        return $this->links_noindex;
    }

    /**
     * @param bool $links_noindex
     * @return Post
     */
    public function setLinksNoindex(bool $links_noindex): self
    {
        $this->links_noindex = $links_noindex;
        return $this;
    }
}