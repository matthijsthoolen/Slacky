<?php

namespace MatthijsThoolen\Slacky\Model;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class SlackyResponse
{
    /** @var array */
    private $body;

    /** @var Object|Object[] */
    private $object;

    /** @var int */
    private $statusCode;

    /** @var string */
    private $reasonPhrase;

    /** @var bool */
    private $ok = false;

    /** @var string */
    private $error;

    /** @var float */
    private $latest;

    /** @var bool */
    private $hasMore = false;

    /** @var string */
    private $nextCursor;

    /**
     * SlackyResponse constructor.
     * @param ResponseInterface $response
     * @throws Exception
     */
    public function __construct(ResponseInterface $response)
    {
        $this->statusCode   = $response->getStatusCode();
        $this->reasonPhrase = $response->getReasonPhrase();

        if ($this->statusCode === 200) {
            $this->processBody($response->getBody());
        }
    }

    /**
     * @return Object|Object[]
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param Object|Object[] $object
     * @return $this
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->ok;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error ?? $this->reasonPhrase ?? 'Unknown error with statuscode ' . $this->statusCode;
    }

    /**
     * @return float
     */
    public function getLatest(): float
    {
        return $this->latest;
    }

    /**
     * @return bool
     */
    public function isHasMore(): bool
    {
        return $this->hasMore;
    }

    /**
     * @return string
     */
    public function getNextCursor(): string
    {
        return $this->nextCursor;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * This __call only processes functions starting with get. Use this functionallity to retrieve fields
     * from the body. For example to retrieve the response_metadata field call the getResponseMetadata method
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (substr($method, 0, 3) === 'get') {
            return $this->dynamicGet(str_replace('get', '', $method));
        } else {
            trigger_error('Unknown function '.__CLASS__.':'.$method, E_USER_ERROR);
        }

        return null;
    }

    /**
     * @param string $paramName
     * @return mixed
     */
    private function dynamicGet($paramName)
    {
        // Add underscores before capitals. And remove all capitals
        $paramName = strtolower(preg_replace('/\B([A-Z])/', '_$1', $paramName));

        return $this->body[$paramName] ?? null;
    }

    /**
     * @param StreamInterface $bodyStream
     * @throws Exception
     */
    private function processBody($bodyStream)
    {
        if ($bodyStream->isReadable() === false) {
            throw new Exception('Response body could not be read from');
        }

        $this->body = json_decode($bodyStream->getContents(), true);

        $this->ok      = $this->body['ok'] ?? false;
        $this->error   = $this->body['error'] ?? null;
        $this->latest  = $this->body['latest'] ?? null;
        $this->hasMore = $this->body['has_more'] ?? null;

        if (isset($this->body['response_metadata']) === true) {
            $this->nextCursor = $this->body['response_metadata']['next_cursor'] ?? null;
        }
    }

}
