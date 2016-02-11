<?php

namespace Bleicker\MimeType;

use Bleicker\MimeType\Exceptions\MimeTypeIsAlreadyRegisteredException;
use Bleicker\MimeType\Exceptions\MimeTypeNotFoundException;
use finfo as FileInfo;

/**
 * Class MimeTypeService
 *
 * @package Bleicker\MimeTypeService
 */
class MimeTypeService implements MimeTypeServiceInterface
{

    /**
     * @var MimeType[]
     */
    public static $registeredMimeTypes = [];

    /**
     * Fill default registeredMimeTypes
     */
    public function __construct()
    {
        static::initialize();
    }

    /**
     * @param string $content
     *
     * @return MimeTypeInterface
     * @throws MimeTypeNotFoundException
     */
    public static function getMimeTypeByContent($content)
    {
        static::initialize();

        $fileInfo = new FileInfo(FILEINFO_MIME_TYPE);
        $contentType = $fileInfo->buffer($content);

        $filter = function (MimeType $registeredMimeType) use ($contentType) {
            return $contentType === $registeredMimeType->getContentType();
        };

        /** @var MimeTypeInterface[] $matchingMimeTypes */
        $matchingMimeTypes = array_filter(static::$registeredMimeTypes, $filter);

        return array_shift($matchingMimeTypes);
    }

    /**
     * @param string $extension
     *
     * @return MimeTypeInterface
     * @throws MimeTypeNotFoundException
     */
    public static function getMimeTypeByExtension($extension)
    {
        static::initialize();

        $filter = function (MimeType $registeredMimeType) use ($extension) {
            return $extension === $registeredMimeType->getExtension();
        };

        /** @var MimeTypeInterface[] $matchingMimeTypes */
        $matchingMimeTypes = array_filter(static::$registeredMimeTypes, $filter);

        if (count($matchingMimeTypes) === 0) {
            throw new MimeTypeNotFoundException('Could not find mime-type', 1455184978);
        }

        return array_shift($matchingMimeTypes);
    }

    /**
     * @param string $mimeType
     *
     * @return MimeTypeInterface
     * @throws MimeTypeNotFoundException
     */
    public static function getMimeTypeByContentType($mimeType)
    {
        static::initialize();

        $filter = function (MimeType $registeredMimeType) use ($mimeType) {
            return $mimeType === $registeredMimeType->getContentType();
        };

        /** @var MimeTypeInterface[] $matchingMimeTypes */
        $matchingMimeTypes = array_filter(static::$registeredMimeTypes, $filter);

        if (count($matchingMimeTypes) === 0) {
            throw new MimeTypeNotFoundException('Could not find mime-type', 1455184976);
        }

        return array_shift($matchingMimeTypes);
    }

    /**
     * @param MimeTypeInterface $mimeType
     *
     * @throws MimeTypeIsAlreadyRegisteredException
     * @return void
     */
    public static function registerMimeType(MimeTypeInterface $mimeType)
    {
        static::initialize();

        $filter = function (MimeTypeInterface $registeredMimeType) use ($mimeType) {
            return $registeredMimeType->getIdentity() === $mimeType->getIdentity();
        };

        $matchingMimeTypes = array_filter(static::$registeredMimeTypes, $filter);

        if (count($matchingMimeTypes) > 0) {
            throw new MimeTypeIsAlreadyRegisteredException('MimeType "' . $mimeType->getIdentity(
                ) . '" is already registed ', 1455187403);
        }

        static::$registeredMimeTypes[] = $mimeType;
    }

    /**
     * @return void
     */
    protected static function initialize()
    {
        if (empty(static::$registeredMimeTypes)) {
            $defaultTypes = [
                'application/andrew-inset' => 'ez',
                'application/mac-binhex40' => 'hqx',
                'application/mac-compactpro' => 'cpt',
                'application/msword' => 'doc',
                'application/octet-stream' => 'dll',
                'application/oda' => 'oda',
                'application/pdf' => 'pdf',
                'application/postscript' => 'ps',
                'application/smil' => 'smil',
                'application/vnd.wap.wbxml' => 'wbxml',
                'application/vnd.wap.wmlc' => 'wmlc',
                'application/vnd.wap.wmlscriptc' => 'wmlsc',
                'application/x-bcpio' => 'bcpio',
                'application/x-cdlink' => 'vcd',
                'application/x-chess-pgn' => 'pgn',
                'application/x-cpio' => 'cpio',
                'application/x-csh' => 'csh',
                'application/x-director' => 'dxr',
                'application/json' => 'json',
                'application/x-dvi' => 'dvi',
                'application/x-futuresplash' => 'spl',
                'application/x-gtar' => 'gtar',
                'application/x-hdf' => 'hdf',
                'application/x-javascript' => 'js',
                'application/x-koan' => 'skm',
                'application/x-latex' => 'latex',
                'application/x-netcdf' => 'cdf',
                'application/x-sh' => 'sh',
                'application/x-shar' => 'shar',
                'application/x-shockwave-flash' => 'swf',
                'application/x-stuffit' => 'sit',
                'application/x-sv4cpio' => 'sv4cpio',
                'application/x-sv4crc' => 'sv4crc',
                'application/x-tar' => 'tar',
                'application/x-tcl' => 'tcl',
                'application/x-tex' => 'tex',
                'application/x-texinfo' => 'texi',
                'application/x-troff' => 'roff',
                'application/x-troff-man' => 'man',
                'application/x-troff-me' => 'me',
                'application/x-troff-ms' => 'ms',
                'application/x-ustar' => 'ustar',
                'application/x-wais-source' => 'src',
                'application/xhtml+xml' => 'xht',
                'application/zip' => 'zip',
                'audio/basic' => 'snd',
                'audio/midi' => 'kar',
                'audio/mpeg' => 'mp3',
                'audio/x-aiff' => 'aifc',
                'audio/x-mpegurl' => 'm3u',
                'audio/x-pn-realaudio' => 'rm',
                'audio/x-pn-realaudio-plugin' => 'rpm',
                'audio/x-realaudio' => 'ra',
                'audio/x-wav' => 'wav',
                'chemical/x-pdb' => 'pdb',
                'chemical/x-xyz' => 'xyz',
                'image/bmp' => 'bmp',
                'image/gif' => 'gif',
                'image/ief' => 'ief',
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/tiff' => 'tiff',
                'image/tif' => 'tif',
                'image/vnd.djvu' => 'djv',
                'image/vnd.wap.wbmp' => 'wbmp',
                'image/x-cmu-raster' => 'ras',
                'image/x-portable-anymap' => 'pnm',
                'image/x-portable-bitmap' => 'pbm',
                'image/x-portable-graymap' => 'pgm',
                'image/x-portable-pixmap' => 'ppm',
                'image/x-rgb' => 'rgb',
                'image/x-xbitmap' => 'xbm',
                'image/x-xpixmap' => 'xpm',
                'image/x-windowdump' => 'xwd',
                'model/iges' => 'iges',
                'model/mesh' => 'silo',
                'model/vrml' => 'vrml',
                'text/css' => 'css',
                'text/html' => 'htm',
                'text/plain' => 'txt',
                'text/richtext' => 'rtx',
                'text/rtf' => 'rtf',
                'text/sgml' => 'sgm',
                'text/tab-seperated-values' => 'tsv',
                'text/vnd.wap.wml' => 'wml',
                'text/vnd.wap.wmlscript' => 'wmls',
                'text/x-setext' => 'etx',
                'text/xml' => 'xsl',
                'video/mpeg' => 'mpe',
                'video/quicktime' => 'mov',
                'video/vnd.mpegurl' => 'mxu',
                'video/x-msvideo' => 'avi',
                'video/x-sgi-movie' => 'movie',
                'x-conference-xcooltalk' => 'ice'
            ];

            foreach ($defaultTypes as $contentType => $extension) {
                static::$registeredMimeTypes[] = new MimeType($contentType, $extension);
            }
        }
    }
}
