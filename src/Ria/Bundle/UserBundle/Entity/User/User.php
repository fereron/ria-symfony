<?php

declare(strict_types=1);

namespace Ria\Bundle\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\{Collection, ArrayCollection};

/**
 * Class User
 * @package Ria\Bundle\UserBundle\Entity\User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Ria\Bundle\UserBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", name="email_additional")
     */
    private string $emailAdditional;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $status = false;

    /**
     * @ORM\Column(type="string")
     */
    private string $gender;

    /**
     * @ORM\Column(type="string")
     */
    private string $phone;

    /**
     * @ORM\Column(type="string", name="birthdate")
     */
    private string $birthDate;

    /**
     * @ORM\Column(type="string", name="last_access_date")
     */
    private string $lastAccessDate;

    /**
     * @ORM\Column(type="string")
     */
    private string $thumb;

    /**
     * @ORM\OneToMany(
     *     targetEntity="",
     *     mappedBy="user",
     *     cascade={"persist", "remove"},
     *     indexBy="language",
     *     fetch="EAGER"
     *  )
     */
    private Collection $translations;

    /**
     * @ORM\ManyToMany(targetEntity="")
     */
    private Collection $roles;

    /**
     * @ORM\ManyToMany(targetEntity="", indexBy="name")
     */
    private Collection $permissions;

    /**
     * @ORM\OneToMany(targetEntity="", mappedBy="author", cascade={"persist", "remove"})
     */
    private Collection $posts;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->roles        = new ArrayCollection();
        $this->permissions  = new ArrayCollection();
        $this->posts        = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmailAdditional(): string
    {
        return $this->emailAdditional;
    }

    /**
     * @param string $emailAdditional
     */
    public function setEmailAdditional(string $emailAdditional): void
    {
        $this->emailAdditional = $emailAdditional;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate(string $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return string
     */
    public function getLastAccessDate(): string
    {
        return $this->lastAccessDate;
    }

    /**
     * @param string $lastAccessDate
     */
    public function setLastAccessDate(string $lastAccessDate): void
    {
        $this->lastAccessDate = $lastAccessDate;
    }

    /**
     * @return string
     */
    public function getThumb(): string
    {
        return $this->thumb;
    }

    /**
     * @param string $thumb
     */
    public function setThumb(string $thumb): void
    {
        $this->thumb = $thumb;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param ArrayCollection|Collection $translations
     */
    public function setTranslations($translations): void
    {
        $this->translations = $translations;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param ArrayCollection|Collection $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param ArrayCollection|Collection $permissions
     */
    public function setPermissions($permissions): void
    {
        $this->permissions = $permissions;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param ArrayCollection|Collection $posts
     */
    public function setPosts($posts): void
    {
        $this->posts = $posts;
    }
}