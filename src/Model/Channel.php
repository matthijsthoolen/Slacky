<?php

namespace MatthijsThoolen\Slacky\Model;

use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\SlackyFactory;

/**
 * Documentation: https://api.slack.com/methods/channels.list
 */
class Channel extends Conversation
{
    /** @var string */
    protected $id;

    /** @var string */
    private $name;

    /** @var bool */
    private $isChannel;

    /** @var int */
    private $created;

    /** @var string */
    private $creator;

    /** @var bool */
    private $isArchived;

    /** @var bool */
    private $isGeneral;

    /** @var bool */
    private $isPrivate;

    /** @var bool */
    private $isMpim;

    /** @var array */
    protected $members;

    /** @var array */
    private $topic;

    /** @var array */
    private $purpose;

    /** @var array */
    private $previousNames;

    /** @var int */
    private $numMembers;

    /** @var string  */
    protected $endpointName = 'Channels.Info';

    /** @var array */
    protected $allowedProperties = array(
        'id',
        'name',
        'is_channel',
        'created',
        'creator',
        'is_archived',
        'is_general',
        'is_private',
        'is_mpim',
        'members',
        'topic',
        'purpose',
        'previous_names',
        'num_members'
    );

    /**
     * @return string
     * @throws SlackyException
     */
    public function getName(): string
    {
        parent::get();
        return $this->name;
    }

    /**
     * @param string $name
     * @return Channel
     */
    public function setName(string $name): Channel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     * @throws SlackyException
     */
    public function isChannel(): bool
    {
        parent::get();
        return $this->isChannel;
    }

    /**
     * @param bool $isChannel
     * @return Channel
     */
    public function setIsChannel(bool $isChannel): Channel
    {
        $this->isChannel = $isChannel;
        return $this;
    }

    /**
     * @return int
     * @throws SlackyException
     */
    public function getCreated(): int
    {
        parent::get();
        return $this->created;
    }

    /**
     * @param int $created
     * @return Channel
     */
    public function setCreated(int $created): Channel
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return string
     * @throws SlackyException
     */
    public function getCreator(): string
    {
        parent::get();
        return $this->creator;
    }

    /**
     * @param string $creator
     * @return Channel
     */
    public function setCreator(string $creator): Channel
    {
        $this->creator = $creator;
        return $this;
    }

    /**
     * @return bool
     * @throws SlackyException
     */
    public function isArchived(): bool
    {
        parent::get();
        return $this->isArchived;
    }

    /**
     * @param bool $isArchived
     * @return Channel
     */
    public function setIsArchived(bool $isArchived): Channel
    {
        $this->isArchived = $isArchived;
        return $this;
    }

    /**
     * @return bool
     * @throws SlackyException
     */
    public function isGeneral(): bool
    {
        parent::get();
        return $this->isGeneral;
    }

    /**
     * @param bool $isGeneral
     * @return Channel
     */
    public function setIsGeneral(bool $isGeneral): Channel
    {
        $this->isGeneral = $isGeneral;
        return $this;
    }

    /**
     * @return bool
     * @throws SlackyException
     */
    public function isPrivate(): bool
    {
        parent::get();
        return $this->isPrivate;
    }

    /**
     * @param bool $isPrivate
     * @return Channel
     */
    public function setIsPrivate(bool $isPrivate): Channel
    {
        $this->isPrivate = $isPrivate;
        return $this;
    }

    /**
     * @return bool
     * @throws SlackyException
     */
    public function isMpim(): bool
    {
        parent::get();
        return $this->isMpim;
    }

    /**
     * @param bool $isMpim
     * @return Channel
     */
    public function setIsMpim(bool $isMpim): Channel
    {
        $this->isMpim = $isMpim;
        return $this;
    }

    /**
     * @param array $members
     * @return Channel
     * @throws SlackyException
     */
    public function setMembers(array $members): Channel
    {
        $this->members = [];

        foreach ($members as $member) {
            /** @var User $user */
            $user = SlackyFactory::buildModel(User::class);
            $user->setId($member);

            $this->members[] = $user;
        }

        return $this;
    }

    /**
     * @return array
     * @throws SlackyException
     */
    public function getTopic(): array
    {
        parent::get();
        return $this->topic;
    }

    /**
     * @param array $topic
     * @return Channel
     */
    public function setTopic(array $topic): Channel
    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * @return array
     * @throws SlackyException
     */
    public function getPurpose(): array
    {
        parent::get();
        return $this->purpose;
    }

    /**
     * @param array $purpose
     * @return Channel
     */
    public function setPurpose(array $purpose): Channel
    {
        $this->purpose = $purpose;
        return $this;
    }

    /**
     * @return array
     * @throws SlackyException
     */
    public function getPreviousNames(): array
    {
        parent::get();
        return $this->previousNames;
    }

    /**
     * @param array $previousNames
     * @return Channel
     */
    public function setPreviousNames(array $previousNames): Channel
    {
        $this->previousNames = $previousNames;
        return $this;
    }

    /**
     * @return int
     * @throws SlackyException
     */
    public function getNumMembers(): int
    {
        parent::get();
        return $this->numMembers;
    }

    /**
     * @param int $numMembers
     * @return Channel
     */
    public function setNumMembers(int $numMembers): Channel
    {
        $this->numMembers = $numMembers;
        return $this;
    }
}
