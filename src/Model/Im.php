<?php

namespace MatthijsThoolen\Slacky\Model;

class Im extends Model
{
    /** @var string */
    private $id;

    /** @var int */
    private $created;

    /** @var bool */
    private $is_im;

    /** @var bool */
    private $is_org_shared;

    /** @var string */
    private $user;

    /** @var bool */
    private $is_user_deleted;

    /** @var array */
    protected $allowedProperties = array(
        'id',
        'created',
        'is_im',
        'is_org_shared',
        'user',
        'is_user_deleted'
    );

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Im
     */
    public function setId(string $id): Im
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreated(): int
    {
        return $this->created;
    }

    /**
     * @param int $created
     * @return Im
     */
    public function setCreated(int $created): Im
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIsIm(): bool
    {
        return $this->is_im;
    }

    /**
     * @param bool $is_im
     * @return Im
     */
    public function setIsIm(bool $is_im): Im
    {
        $this->is_im = $is_im;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIsOrgShared(): bool
    {
        return $this->is_org_shared;
    }

    /**
     * @param bool $is_org_shared
     * @return Im
     */
    public function setIsOrgShared(bool $is_org_shared): Im
    {
        $this->is_org_shared = $is_org_shared;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return Im
     */
    public function setUser(string $user): Im
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIsUserDeleted(): bool
    {
        return $this->is_user_deleted;
    }

    /**
     * @param bool $is_user_deleted
     * @return Im
     */
    public function setIsUserDeleted(bool $is_user_deleted): Im
    {
        $this->is_user_deleted = $is_user_deleted;
        return $this;
    }

}
