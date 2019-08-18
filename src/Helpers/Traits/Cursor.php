<?php

namespace MatthijsThoolen\Slacky\Helpers\Traits;

use MatthijsThoolen\Slacky\Model\SlackyResponse;

trait Cursor
{
    /** @var string */
    private $cursor;

    /** @var int */
    private $limit;

    /** @var array */
    protected $parameters = [];

    /**
     * @return mixed
     */
    public function getCursor()
    {
        return $this->cursor;
    }

    /**
     * @param mixed $cursor
     *
     * @return $this
     */
    public function setCursor($cursor)
    {
        $this->cursor = $this->parameters['cursor'] = $cursor;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function setLimit(int $limit)
    {
        $this->limit = $this->parameters['limit'] = $limit;
        return $this;
    }

    /**
     * @return SlackyResponse
     */
    public function nextPage()
    {
        if ($this->getCursor() === null) {
            return null;
        }

        $response = $this->send();

        if ($response->isOk() && $response->getNextCursor() !== '') {
            $this->setCursor($response->getNextCursor());
        } else {
            $this->setCursor(null);
        }

        return $response;
    }

    /**
     * @return SlackyResponse
     */
    abstract public function send();
}
