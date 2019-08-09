<?php

namespace MatthijsThoolen\Slacky\Model;

use MatthijsThoolen\Slacky\Endpoint\Im\Close;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\SlackyFactory;

class Im extends Model
{
    /** @var string */
    private $id;

    /** @var int */
    private $created;

    /** @var bool */
    private $is_archived;

    /** @var bool */
    private $is_im;

    /** @var bool */
    private $is_org_shared;

    /** @var User */
    private $user;

    /** @var float */
    private $last_read;

    /** @var array */
    private $latest;

    /** @var int */
    private $unread_count;

    /** @var int */
    private $unread_count_display;

    /** @var bool */
    private $is_open;

    /** @var int */
    private $priority;

    /** @var bool */
    private $is_user_deleted;

    /** @var array */
    protected $allowedProperties = array(
        'id',
        'created',
        'is_archived',
        'is_im',
        'is_org_shared',
        'user',
        'last_read',
        'latest',
        'unread_count',
        'unread_count_display',
        'is_open',
        'priority',
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
    public function isArchived(): bool
    {
        return $this->is_archived;
    }

    /**
     * @param bool $is_archived
     * @return Im
     */
    public function setIsArchived(bool $is_archived): Im
    {
        $this->is_archived = $is_archived;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIm(): bool
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
    public function isOrgShared(): bool
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User|string $user
     * @return Im
     */
    public function setUser($user): Im
    {
        if ($user instanceof User) {
            $this->user = $user;

            return $this;
        }

        $this->user = new User();
        $this->user->setId($user);
        return $this;
    }

    /**
     * @return float
     */
    public function getLastRead(): float
    {
        return $this->last_read;
    }

    /**
     * @param float $last_read
     * @return Im
     */
    public function setLastRead(float $last_read): Im
    {
        $this->last_read = $last_read;
        return $this;
    }

    /**
     * @return array
     */
    public function getLatest(): array
    {
        return $this->latest;
    }

    /**
     * @param array $latest
     * @return Im
     */
    public function setLatest(array $latest): Im
    {
        $this->latest = $latest;
        return $this;
    }

    /**
     * @return int
     */
    public function getUnreadCount(): int
    {
        return $this->unread_count;
    }

    /**
     * @param int $unread_count
     * @return Im
     */
    public function setUnreadCount(int $unread_count): Im
    {
        $this->unread_count = $unread_count;
        return $this;
    }

    /**
     * @return int
     */
    public function getUnreadCountDisplay(): int
    {
        return $this->unread_count_display;
    }

    /**
     * @param int $unread_count_display
     * @return Im
     */
    public function setUnreadCountDisplay(int $unread_count_display): Im
    {
        $this->unread_count_display = $unread_count_display;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->is_open;
    }

    /**
     * @param bool $is_open
     * @return Im
     */
    public function setIsOpen(bool $is_open): Im
    {
        $this->is_open = $is_open;
        return $this;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return Im
     */
    public function setPriority(int $priority): Im
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUserDeleted(): bool
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

    /** ACTIONS */

    /**
     * @return bool
     * @throws SlackyException
     */
    public function close()
    {
        /** @var Close $ImClose */
        $ImClose  = SlackyFactory::build(Close::class);
        $response = $ImClose->setIm($this)->send();

        return $response->isOk();
    }
}
