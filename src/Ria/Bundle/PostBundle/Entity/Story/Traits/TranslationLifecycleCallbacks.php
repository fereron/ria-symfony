<?php

namespace Ria\News\Core\Models\Story\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ria\Core\Models\Meta;

trait TranslationLifecycleCallbacks
{

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist()
    {
        $this->meta = $this->getMeta()->encode();
    }

    /**
     * @ORM\PostLoad()
     */
    public function postLoad()
    {
        $this->meta = Meta::fromJson($this->meta);
    }

}