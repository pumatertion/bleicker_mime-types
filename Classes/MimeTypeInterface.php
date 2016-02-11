<?php

namespace Bleicker\MimeType;

/**
 * Class MimeTypeInterface
 *
 * @package Bleicker\MimeTypeService
 */
interface MimeTypeInterface
{

    /**
     * @return string
     */
    public function getExtension();

    /**
     * @return string
     */
    public function getContentType();

    /**
     * @return string
     */
    public function getIdentity();
}
