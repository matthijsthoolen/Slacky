<?php

namespace MatthijsThoolen\Slacky\Helpers\Traits;

use MatthijsThoolen\Slacky\Model\SlackyResponse;

trait PaginationByTime
{
    use Pagination {
        Pagination::nextPage as parentNextPage;
        Pagination::hasNextPage as parentHasNextPage;
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
        return $this->latest !== null || $this->oldest !== null || $this->parentHasNextPage() !== false;
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

        $response = $this->send();

        $this->setOldest(null);

        // Reset latest and oldest if no more messages available
        if ($response->isHasMore() === false) {
            $this->setLatest(null);

            return $response;
        }

        $this->setLatest($response->getLatest());

        return $response;
    }
}
