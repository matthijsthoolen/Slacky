<?php

namespace MatthijsThoolen\Slacky\Endpoint\Files;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\File\File;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

/**
 * Class Upload
 * @documentation https://api.slack.com/methods/files.upload
 */
class Upload extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $contentType = 'urlencoded';

    /** @var string */
    protected $uri = 'files.upload';

    /** @var File */
    protected $file;

    /**
     * @param File $file
     * @return $this
     */
    public function setFile(File $file)
    {
        $this->file = $this->parameters = $file;

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        $this->parameters = array_filter(
            [
                'channels'        => implode(',', $this->file->getChannels()),
                'content'         => $this->file->getContent(),
                'file'            => $this->file->getFile(),
                'filename'        => $this->file->getFilename(),
                'filetype'        => $this->file->getFileType(),
                'initial_comment' => $this->file->getInitialComment(),
                'title'           => $this->file->getTitle(),
                'thread_ts'       => $this->file->getThreadTs()
            ]
        );

        return parent::getParameters();
    }

    /**
     * @param SlackyResponse $response
     * @return File
     * @throws \Exception
     */
    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        /** @noinspection PhpUndefinedMethodInspection */
        $body = $response->getFile();

        $this->file->loadData($body);

        return $this->file;
    }
}
