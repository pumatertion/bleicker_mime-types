<?php

namespace Bleicker\MimeType;

/**
 * Class MimeType
 *
 * @package Bleicker\MimeTypeService
 */
class MimeType implements MimeTypeInterface
{

    /**
     * @var string
     */
    protected $contentType;

    /**
     * @var string
     */
    protected $extension;

    /**
     * @param string $contentType
     * @param string $extension
     */
    public function __construct($contentType, $extension)
    {
        $this->contentType = $contentType;
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @return string
     */
    public final function getIdentity()
    {
        return $this->getContentType() . '::' . $this->getExtension();
    }
}
