<?php

namespace Bleicker\MimeType\Tests\Unit;

use Bleicker\MimeType\MimeType;
use PHPUnit_Framework_TestCase as UnitTestCase;

/**
 * Class MimeTypeTest
 *
 * @package Bleicker\MimeType\Tests\Unit
 */
class MimeTypeTest extends UnitTestCase
{

    /**
     * @test
     */
    public function constructorTest()
    {
        $mimeType = new MimeType('application/json', 'json');
        $this->assertEquals('json', $mimeType->getExtension());
        $this->assertEquals('application/json', $mimeType->getContentType());
    }
}
