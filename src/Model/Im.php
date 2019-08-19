<?php

namespace MatthijsThoolen\Slacky\Model;

use MatthijsThoolen\Slacky\Endpoint\Conversations\Info;
use MatthijsThoolen\Slacky\Endpoint\Im\Close;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\SlackyFactory;

class Im extends Conversation
{
    /** @var string */
    protected $id;

    /** @var int */
    private $created;

    /** @var bool */
    private $is_archived = false;

    /** @var bool */
    private $is_im = true;

    /** @var bool */
    private $is_org_shared = false;

    /** @var User|null */
    private $user;

    /** @var string */
    private $last_read;

    /** @var array */
    private $latest;

    /** @var int */
    private $unread_count;

    /** @var int */
    private $unread_count_display;

    /** @var bool */
    private $is_open = false;

    /** @var int */
    private $priority;

    /** @var bool */
    private $is_user_deleted = false;

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
     * @return User|null
     */
    public function getUser()
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
     * @return string
     */
    public function getLastRead(): string
    {
        return $this->last_read;
    }

    /**
     * @param string $last_read
     * @return Im
     */
    public function setLastRead(string $last_read): Im
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
     * @return $this
     * @throws SlackyException
     */
    public function refreshInfo()
    {
        /** @var Info $info */
        $info = SlackyFactory::make(Info::class);
        $info->setConversation($this)->send();

        return $this;
    }

    /**
     * @return bool
     * @throws SlackyException
     */
    public function close()
    {
        /** @var Close $ImClose */
        $ImClose  = SlackyFactory::make(Close::class);
        $response = $ImClose->setIm($this)->send();

        return $response->isOk();
    }
}
