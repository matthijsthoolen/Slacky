<?php

namespace MatthijsThoolen\Slacky\Endpoint\Files;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\File\File;

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
                'title'           => $this->file->getTitle()
            ]
        );

        return parent::getParameters();
    }
}
