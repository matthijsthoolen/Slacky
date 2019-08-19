<?php

namespace MatthijsThoolen\Slacky\Helpers\Traits;

use MatthijsThoolen\Slacky\Model\SlackyResponse;

trait Pagination
{
    /** @var string */
    private $cursor;

    /** @var int */
    private $limit = 100;

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

    public function hasNextPage()
    {
        return $this->getCursor() !== null;
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
        $this->setCursor($response->getNextCursor() !== '' ? $response->getNextCursor() : null);

        return $response;
    }

    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        $this->setCursor($response->getNextCursor());

        return $response;
    }

    /**
     * @return SlackyResponse
     */
    abstract public function send();
}
