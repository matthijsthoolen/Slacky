<?php

namespace MatthijsThoolen\Slacky\Helpers\Traits;

use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

trait PaginationByTime
{
    use Pagination {
        Pagination::nextPage as parentNextPage;
        Pagination::hasNextPage as parentHasNextPage;
        Pagination::handleResponse as parentHandleResponse;
    }

    /** @var bool */
    protected $inclusive = false;

    /** @var string */
    protected $latest;

    /** @var string */
    protected $oldest;

    /**
     * @return bool
     */
    public function isInclusive(): bool
    {
        return $this->inclusive;
    }

    /**
     * @param bool $inclusive
     *
     * @return $this
     */
    public function setInclusive(bool $inclusive)
    {
        $this->inclusive = $this->parameters['inclusive'] = $inclusive;
        return $this;
    }

    /**
     * @return string
     */
    public function getLatest()
    {
        return $this->latest;
    }

    /**
     * @param string $latest
     *
     * @return $this
     */
    public function setLatest($latest)
    {
        $this->latest = $this->parameters['latest'] = $latest;
        return $this;
    }

    /**
     * @return string
     */
    public function getOldest()
    {
        return $this->oldest;
    }

    /**
     * @param string $oldest
     *
     * @return $this
     */
    public function setOldest($oldest)
    {
        $this->oldest = $this->parameters['oldest'] = $oldest;
        return $this;
    }

    public function hasNextPage()
    {
        return $this->latest !== null ||
            $this->oldest !== null ||
            $this->parentHasNextPage() !== false;
    }

    /**
     * @return SlackyResponse
     */
    public function nextPage()
    {
        // If latest and oldest are not set, assume cursor-based pagination is expected
        if ($this->latest === null && $this->oldest === null) {
            return $this->parentNextPage();
        }

        return $this->send();
    }

    /**
     * @param SlackyResponse $response
     *
     * @return SlackyResponse
     * @throws SlackyException
     */
    public function handleResponse(SlackyResponse $response)
    {
        // Make sure the pagination logic is called when we dont deal with timeBased pagination
        if ($this->latest === null && $this->oldest === null) {
            return $this->parentHandleResponse($response);
        }

        // call endpoints handleResponse
        parent::handleResponse($response);

        // Reset latest
        $this->setLatest(null);

        $response->setObject($this->getObjectFromResponse($response));

        // If there is more, get the objects from the response
        if ($response->isHasMore()) {
            $objects    = $response->getObject();
            $lastObject = end($objects);
            $this->setLatest($lastObject->getTs());
        }

        return $response;
    }

    /**
     * Return a object corresponding to the endpoint
     *
     * @param SlackyResponse $response
     *
     * @return mixed
     */
    abstract protected function getObjectFromResponse(SlackyResponse $response);
}
