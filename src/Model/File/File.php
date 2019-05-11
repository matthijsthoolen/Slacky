<?php

namespace MatthijsThoolen\Slacky\Model\File;

use MatthijsThoolen\Slacky\Model\Model;

class File extends Model
{
    /** @var string */
    private $id;

    /** @var int */
    private $created;

    /** @var int */
    private $timestamp;

    /** @var string */
    private $content;

    /** @var mixed */
    private $file;

    /** @var string */
    private $initial_comment;

    /** @var string */
    private $filename;

    /** @var string */
    private $name;

    /** @var string */
    private $title;

    /** @var string */
    private $mimeType;

    /** @var string */
    private $fileType;

    /** @var string */
    private $pretty_type;

    /** @var string */
    private $user;

    /** @var bool */
    private $editable = false;

    /** @var int */
    private $size;

    /** @var string */
    private $mode;

    /** @var string */
    private $preview;

    /** @var string */
    private $preview_highlight;

    /** @var int */
    private $lines;

    /** @var int */
    private $lines_more;

    /** @var array */
    private $channels = [];

    protected $allowedProperties = [
        'id',
        'created',
        'timestamp',
        'name',
        'title',
        'mimetype',
        'filetype',
        'pretty_type',
        'user',
        'editable',
        'size',
        'mode',
        'preview',
        'preview_highlight',
        'lines',
        'lines_more',
        'channels'
    ];

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return File
     */
    public function setId(string $id): File
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return File
     */
    public function setContent(string $content): File
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     * @return File
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string
     */
    public function getInitialComment(): ?string
    {
        return $this->initial_comment;
    }

    /**
     * @param string $initial_comment
     * @return File
     */
    public function setInitialComment(string $initial_comment): File
    {
        $this->initial_comment = $initial_comment;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return File
     */
    public function setFilename(string $filename): File
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreated(): int
    {
        return $this->created;
    }

    /**
     * @param int $created
     * @return File
     */
    public function setCreated(int $created): File
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     * @return File
     */
    public function setTimestamp(int $timestamp): File
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return File
     */
    public function setName(string $name): File
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return File
     */
    public function setTitle(string $title): File
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     * @return File
     */
    public function setMimeType(string $mimeType): File
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileType(): ?string
    {
        return $this->fileType;
    }

    /**
     * @param string $fileType
     * @return File
     */
    public function setFileType(string $fileType): File
    {
        $this->fileType = $fileType;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrettyType(): ?string
    {
        return $this->pretty_type;
    }

    /**
     * @param string $pretty_type
     * @return File
     */
    public function setPrettyType(string $pretty_type): File
    {
        $this->pretty_type = $pretty_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return File
     */
    public function setUser(string $user): File
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEditable(): bool
    {
        return $this->editable;
    }

    /**
     * @param bool $editable
     * @return File
     */
    public function setEditable(bool $editable): File
    {
        $this->editable = $editable;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return File
     */
    public function setSize(int $size): File
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return string
     */
    public function getMode(): ?string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     * @return File
     */
    public function setMode(string $mode): File
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return string
     */
    public function getPreview(): ?string
    {
        return $this->preview;
    }

    /**
     * @param string $preview
     * @return File
     */
    public function setPreview(string $preview): File
    {
        $this->preview = $preview;
        return $this;
    }

    /**
     * @return string
     */
    public function getPreviewHighlight(): ?string
    {
        return $this->preview_highlight;
    }

    /**
     * @param string $preview_highlight
     * @return File
     */
    public function setPreviewHighlight(string $preview_highlight): File
    {
        $this->preview_highlight = $preview_highlight;
        return $this;
    }

    /**
     * @return int
     */
    public function getLines(): int
    {
        return $this->lines;
    }

    /**
     * @param int $lines
     * @return File
     */
    public function setLines(int $lines): File
    {
        $this->lines = $lines;
        return $this;
    }

    /**
     * @return int
     */
    public function getLinesMore(): int
    {
        return $this->lines_more;
    }

    /**
     * @param int $lines_more
     * @return File
     */
    public function setLinesMore(int $lines_more): File
    {
        $this->lines_more = $lines_more;
        return $this;
    }

    /**
     * @return array
     */
    public function getChannels(): array
    {
        return $this->channels;
    }

    /**
     * @param array $channels
     * @return File
     */
    public function setChannels(array $channels): File
    {
        $this->channels = $channels;
        return $this;
    }

    /**
     * Add a channel
     * @param string $channel
     * @return File
     */
    public function addChannel(string $channel): File
    {
        $this->channels[] = $channel;
        return $this;
    }
}
