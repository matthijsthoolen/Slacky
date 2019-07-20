<?php

namespace MatthijsThoolen\Slacky\Exception;

use Exception;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use Throwable;

class SlackyException extends Exception
{
    /** @var SlackyResponse */
    protected $slackyResponse;

    /**
     * SlackyException constructor.
     * @param string $message
     * @param int $code
     * @param SlackyResponse|null $response
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, SlackyResponse $response = null, Throwable $previous = null)
    {
        $this->slackyResponse = $response;

        parent::__construct($message, $code, $previous);
    }

    public function getSlackyResponse()
    {
        return $this->slackyResponse;
    }
}
