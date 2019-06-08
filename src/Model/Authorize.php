<?php

namespace MatthijsThoolen\Slacky\Model;

class Authorize extends Model
{
    const ADMIN                     = 'admin';
    const AUDITLOGS_READ            = 'auditlogs:read';
    const BOT                       = 'bot';
    const CHANNELS_HISTORY          = 'channels:history';
    const CHANNELS_READ             = 'channels:read';
    const CHANNELS_WRITE            = 'channels:write';
    const CHAT_WRITE                = 'chat:write';
    const CHAT_WRITE_BOT            = 'chat:write:bot';
    const CHAT_WRITE_USER           = 'chat:write:user';
    const CLIENT                    = 'client';
    const COMMANDS                  = 'commands';
    const CONVERSATIONS_WRITE       = 'conversations:write';
    const DND_READ                  = 'dnd:read';
    const DND_WRITE                 = 'dnd:write';
    const DND_WRITE_USER            = 'dnd:write:user';
    const EMOJI_READ                = 'emoji:read';
    const FILES_READ                = 'files:read';
    const FILES_WRITE               = 'files:write';
    const FILES_WRITE_USER          = 'files:write:user';
    const GROUPS_HISTORY            = 'groups:history';
    const GROUPS_READ               = 'groups:read';
    const GROUPS_WRITE              = 'groups:write';
    const IDENTITY                  = 'identiTy';
    const IDENTITY_AVATAR           = 'identity:avatar';
    const IDENTITY_AVATAR_READ_USER = 'identity.avatar:read:user';
    const IDENTITY_BASIC            = 'identity.basic';
    const IDENTITY_EMAIL            = 'identity.email';
    const IDENTITY_EMAIL_READ_USER  = 'identity.email:read:user';
    const IDENTITY_TEAM             = 'identity.team';
    const IDENTITY_TEAM_READ_USER   = 'identity.team:read:user';
    const IDENTITY_READ_USER        = 'identity:read:user';
    const IM_HISTORY                = 'im:history';
    const IM_READ                   = 'im:read';
    const IM_WRITE                  = 'im:write';
    const INCOMING_WEBHOOK          = 'incoming-webhook';
    const LINKS_READ                = 'links:read';
    const LINKS_WRITE               = 'links:write';
    const MPIM_HISTORY              = 'mpim:history';
    const MPIM_READ                 = 'mpim:read';
    const MPIM_WRITE                = 'mpim:write';
    const NONE                      = 'none';
    const PINS_READ                 = 'pins:read';
    const PINS_WRITE                = 'pins:write';
    const POST                      = 'post';
    const REACTIONS_READ            = 'reactions:read';
    const REACTIONS_WRITE           = 'reactions:write';
    const READ                      = 'read';
    const REMINDERS_READ            = 'reminders:read';
    const REMINDERS_READ_USER       = 'reminders:read:user';
    const REMINDERS_WRITE_USER      = 'reminders:write:user';
    const SEARCH_READ               = 'search:read';
    const STARS_READ                = 'stars:read';
    const STARS_WRITE               = 'stars:write';
    const TEAM_READ                 = 'team:read';
    const TOKENS_BASIC              = 'tokens.basic';
    const USERGROUPS_READ           = 'usergroups:read';
    const USERGROUPS_WRITE          = 'usergroups:write';
    const USERS_PROFILE_READ        = 'users.profile:read';
    const USERS_PROFILE_WRITE       = 'users.profile:write';
    const USERS_PROFILE_WRITE_USER  = 'users.profile:write:user';
    const USERS_READ                = 'users:read';
    const USERS_READ_EMAIL          = 'users:read.email';
    const USERS_WRITE               = 'users:write';

    /** @var $string */
    protected $clientId;

    /** @var array */
    protected $scope = [];

    /** @var string */
    protected $redirectUri;

    /** @var string */
    protected $state;

    /** @var string */
    protected $team;

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     * @return Authorize
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return array
     */
    public function getScope(): array
    {
        return $this->scope;
    }

    /**
     * @param array $scope
     * @return Authorize
     */
    public function setScope(array $scope): Authorize
    {
        $this->scope = $scope;
        return $this;
    }

    /**
     * @param string $scope
     * @return Authorize
     */
    public function addScope($scope): Authorize
    {
        $this->scope[] = $scope;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }

    /**
     * @param string $redirectUri
     * @return Authorize
     */
    public function setRedirectUri(string $redirectUri): Authorize
    {
        $this->redirectUri = $redirectUri;
        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return Authorize
     */
    public function setState(string $state): Authorize
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getTeam(): string
    {
        return $this->team;
    }

    /**
     * @param string $team
     * @return Authorize
     */
    public function setTeam(string $team): Authorize
    {
        $this->team = $team;
        return $this;
    }
}
