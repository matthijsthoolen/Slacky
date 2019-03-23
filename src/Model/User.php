<?php

namespace MatthijsThoolen\Slacky\Model;

class User extends Model
{
    /** @var string */
    private $id;

    /** @var string */
    private $teamId;

    /** @var string */
    private $name;

    /** @var bool */
    private $deleted;

    /** @var string */
    private $color;

    /** @var string */
    private $realName;

    /** @var array */
    private $profile;

    /** @var string */
    protected $objectName = 'user';

    /** @var array */
    protected $allowedProperties = array(
        'id',
        'team_id',
        'name',
        'deleted',
        'color',
        'real_name',
        'profile'
    );

    /**
     * @param string $id
     * @return User
     */
    public function setId(string $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTeamId(): string
    {
        return $this->teamId;
    }

    /**
     * @param string $teamId
     * @return User
     */
    public function setTeamId(string $teamId)
    {
        $this->teamId = $teamId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     * @return User
     */
    public function setDeleted(bool $deleted): User
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return User
     */
    public function setColor(string $color): User
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return string
     */
    public function getRealName(): string
    {
        return $this->realName;
    }

    /**
     * @param string $realName
     * @return User
     */
    public function setRealName(string $realName): User
    {
        $this->realName = $realName;
        return $this;
    }

    /**
     * @return array
     */
    public function getProfile(): array
    {
        return $this->profile;
    }

    /**
     * @param array $profile
     * @return User
     */
    public function setProfile(array $profile): User
    {
        $this->profile = $profile;
        return $this;
    }

}
