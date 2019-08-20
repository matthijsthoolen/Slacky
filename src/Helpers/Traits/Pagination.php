<?php

namespace MatthijsThoolen\Slacky\Helpers\Traits;

use MatthijsThoolen\Slacky\Exception\SlackyException;
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

    /**
     * @param SlackyResponse $response
     */
    public function handlePagination(SlackyResponse $response)
    {
        $this->setCursor($response->getNextCursor());

        return $response;
    }

    /**
     * If this function is overwritten, make sure handlePagination is still called
     *
     * @param SlackyResponse $response
     *
     * @return SlackyResponse
     * @throws SlackyException
     */
    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);
        $this->handlePagination($response);

        return $response;
    }

    /**
     * @return SlackyResponse
     */
    abstract public function send();
}
