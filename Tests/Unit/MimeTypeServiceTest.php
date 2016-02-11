<?php

namespace Bleicker\MimeType\Tests\Unit;

use Bleicker\MimeType\MimeType;
use Bleicker\MimeType\MimeTypeService;
use PHPUnit_Framework_TestCase as UnitTestCase;

/**
 * Class MimeTypeServiceTest
 *
 * @package Bleicker\MimeType\Tests\Unit
 */
class MimeTypeServiceTest extends UnitTestCase
{

    protected function tearDown()
    {
        parent::tearDown();
        MimeTypeService::$registeredMimeTypes = [];
    }

    /**
     * @test
     */
    public function createServiceTest()
    {
        $service = new MimeTypeService();
        $this->assertNotEmpty($service::$registeredMimeTypes);
    }

    /**
     * @test
     */
    public function getMimeTypeByContentTypeTest()
    {
        $this->assertEquals(
            'application/json',
            MimeTypeService::getMimeTypeByContentType('application/json')->getContentType()
        );
        $this->assertEquals('json', MimeTypeService::getMimeTypeByContentType('application/json')->getExtension());
    }

    /**
     * @test
     * @expectedException \Bleicker\MimeType\Exceptions\MimeTypeNotFoundException
     */
    public function getUnknownMimeTypeByContentType()
    {
        MimeTypeService::getMimeTypeByContentType('undefined/undefined');
    }

    /**
     * @test
     * @expectedException \Bleicker\MimeType\Exceptions\MimeTypeNotFoundException
     */
    public function getUnknownMimeTypeByExtension()
    {
        MimeTypeService::getMimeTypeByExtension('undefined');
    }

    /**
     * @test
     */
    public function getMimeTypeByExtensionTest()
    {
        $this->assertEquals('application/json', MimeTypeService::getMimeTypeByExtension('json')->getContentType());
        $this->assertEquals('json', MimeTypeService::getMimeTypeByExtension('json')->getExtension());
    }

    /**
     * @test
     */
    public function getMimeTypeByContentTest()
    {
        $this->assertEquals('text/plain', MimeTypeService::getMimeTypeByContent('just text here')->getContentType());
        $this->assertEquals('txt', MimeTypeService::getMimeTypeByContent('just text here')->getExtension());
    }

    /**
     * @test
     */
    public function registerMimeTypeTest()
    {
        $newMimeType = new MimeType('foo/bar', 'foo');
        MimeTypeService::registerMimeType($newMimeType);
        $this->assertEquals(
            'foo/bar',
            MimeTypeService::getMimeTypeByContentType('foo/bar')->getContentType()
        );
        $this->assertEquals('foo', MimeTypeService::getMimeTypeByContentType('foo/bar')->getExtension());
    }

    /**
     * @test
     * @expectedException \Bleicker\MimeType\Exceptions\MimeTypeIsAlreadyRegisteredException
     */
    public function registerMimeTypeWhichAlreadyExistsTest()
    {
        $newMimeType = new MimeType('application/json', 'json');
        MimeTypeService::registerMimeType($newMimeType);
    }
}
