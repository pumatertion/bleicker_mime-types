<?php

namespace Bleicker\MimeType;

/**
 * Class MimeTypeService
 *
 * @package Bleicker\MimeTypeService
 */
interface MimeTypeServiceInterface
{

    /**
     * @param string $content
     *
     * @return MimeTypeInterface
     */
    public static function getMimeTypeByContent($content);

    /**
     * @param string $extension
     *
     * @return MimeTypeInterface
     */
    public static function getMimeTypeByExtension($extension);

    /**
     * @param string $mimeType
     *
     * @return MimeTypeInterface
     */
    public static function getMimeTypeByContentType($mimeType);

    /**
     * @param MimeTypeInterface $mimeType
     *
     * @return void
     */
    public static function registerMimeType(MimeTypeInterface $mimeType);
}