<?php

namespace Ria\News\Core\Models\Post;

use Ria\Core\Models\Meta;
use Ria\Persons\Core\Models\Person;

/**
 * Class Plain
 * @package Ria\News\Core\Models\Post
 * @property int id
 * @property int group_id
 * @property string language
 * @property int created_by
 * @property string $slug
 * @property array $marked_words
 * @property mixed is_main
 * @property Icon icon
 * @property Type type
 * @property string|null $option_type
 * @property string category
 * @property string author
 * @property string|null city
 * @property string|null story
 * @property string|null youtube_id
 * @property string title
 * @property string description
 * @property Content content
 * @property string|null source
 * @property string published_at
 * @property string status
 * @property string|null image
 * @property mixed is_exclusive
 * @property mixed is_actual
 * @property mixed is_breaking
 * @property bool is_important
 * @property Meta meta
 * @property array tags
 * @property array persons
 * @property array exports
 * @property array related
 * @property array photos
 */
class Plain
{
    public static function fromEntity(Post $post)
    {
        $obj               = new self();
        $obj->id           = $post->getId();
        $obj->language     = $post->getLanguage();
        $obj->icon         = $post->getIcon();
        $obj->type         = $post->getType();
        $obj->option_type  = $post->getOptionType();
        $obj->category     = $post->getCategory()->getTranslation($post->getLanguage())->getTitle();
        $obj->created_by   = $post->getCreatedBy();
        $obj->author       = $post->getAuthor()->getTranslation($post->getLanguage())->getFullName();
        $obj->city         = $post->getCity() ? $post->getCity()->getTranslation($post->getLanguage())->getTitle() : null;
        $obj->story        = $post->getStory() ? $post->getStory()->getTranslation($post->getLanguage())->getTitle() : null;
        $obj->youtube_id   = $post->getYoutubeId();
        $obj->title        = $post->getTitle();
        $obj->description  = $post->getDescription();
        $obj->content      = $post->getContent();
        $obj->source       = $post->getSource();
        $obj->published_at = $post->getPublishedAt()->format('Y-m-d H:i:s');
        $obj->slug         = $post->getSlug();
        $obj->status       = (string)$post->getStatus();
        $obj->marked_words = $post->getMarkedWords();
        $obj->image        = $post->getImage();
        $obj->is_main      = $post->getIsMain();
        $obj->is_exclusive = $post->getIsExclusive();
        $obj->is_actual    = $post->getIsActual();
        $obj->is_breaking  = $post->getIsBreaking();
        $obj->is_important = $post->getIsImportant();
        $obj->meta         = $post->getMeta();
        $obj->tags         = array_map(function (\Ria\News\Core\Models\Tag\Tag $tag) use ($post) {
            return $tag->getTranslation($post->getLanguage())->getName() ?? null;
        }, $post->getTags());
        $obj->persons      = array_map(function (Person $person) use ($post) {
            $personLang = $person->getTranslation($post->getLanguage());
            return $personLang->getFirstName() . ' ' . $personLang->getLastName();
        }, $post->getPersons());
        $obj->exports      = array_map(function (Export $export) {
            return $export->value();
        }, $post->getExports());
        $obj->related      = array_map(function (Post $post) {
            return $post->getTitle();
        }, $post->getRelated());
        $obj->photos       = array_map(function (\Ria\Photos\Core\Models\Photo\Photo $photo) {
            return $photo->getFilename();
        }, $post->getPhotos()->toArray());
        return $obj;
    }
}