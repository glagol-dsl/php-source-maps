<?php
declare(strict_types=1);

namespace GlagolTest\SourceMap;

use Glagol\SourceMap\File;
use Glagol\SourceMap\Mapping;
use Glagol\SourceMap\OriginalFile;
use PHPUnit\Framework\TestCase;

class MappingTest extends TestCase
{
    public function testIfMappingRespondsToAName()
    {
        $mapping = new Mapping(0, 0, $this->fileMock(), 0, 0, 'test_name');

        $this->assertTrue($mapping->isNameEqualTo('test_name'));
        $this->assertFalse($mapping->isNameEqualTo('test_false_name'));
    }

    public function testIfMappingRespondsToAGeneratedLine()
    {
        $generatedLine = rand(0, 10);
        $mapping = new Mapping($generatedLine, 0, $this->fileMock(), 0, 0);

        $this->assertTrue($mapping->isGeneratedLineEqualTo($generatedLine));
        $this->assertFalse($mapping->isGeneratedLineEqualTo($generatedLine + 1));
    }

    /**
     * @return OriginalFile|\PHPUnit_Framework_MockObject_MockObject
     */
    private function fileMock(): OriginalFile
    {
        return $this->createMock(OriginalFile::class);
    }
}
