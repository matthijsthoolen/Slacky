<?php

namespace MatthijsThoolen\Slacky\Endpoint\Im;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Im;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

class Mark extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'im.mark';

    /** @var Im */
    private $channel;

    /** @var string */
    private $ts;

    /**
     * @return Im
     */
    public function getChannel(): Im
    {
        return $this->channel;
    }

    /**
     * @param Im $channel
     * @return Mark
     */
    public function setChannel(Im $channel): Mark
    {
        $this->channel               = $channel;
        $this->parameters['channel'] = $channel->getId();
        return $this;
    }

    /**
     * @return float
     */
    public function getTs(): float
    {
        return $this->ts;
    }

    /**
     * @param string $ts
     * @return Mark
     */
    public function setTs(string $ts): Mark
    {
        $this->ts = $this->parameters['ts'] = $ts;
        return $this;
    }
}
