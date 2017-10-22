<?php
declare(strict_types=1);

namespace GlagolTest\SourceMap;

use Glagol\SourceMap\File;
use Glagol\SourceMap\Mapping;
use Glagol\SourceMap\MappingCollection;
use PHPUnit\Framework\TestCase;

class MappingCollectionTest extends TestCase
{
    public function testShouldFilterByGeneratedLine()
    {
        $generatedLine = rand(0, 10);
        $mapping = new Mapping($generatedLine, 0, $this->fileMock(), 0, 0);

        $mappingCollection = new MappingCollection([$mapping]);

        $this->assertCount(1, $mappingCollection->filterByGeneratedLine($generatedLine));
        $this->assertCount(0, $mappingCollection->filterByGeneratedLine($generatedLine + 1));
    }

    public function testShouldFilterByName()
    {
        $mapping = new Mapping(0, 0, $this->fileMock(), 0, 0, 'test_name');

        $mappingCollection = new MappingCollection([$mapping]);

        $this->assertCount(1, $mappingCollection->filterByName('test_name'));
        $this->assertCount(0, $mappingCollection->filterByName('test_false_name'));
    }

    /**
     * @return File|\PHPUnit_Framework_MockObject_MockObject
     */
    private function fileMock(): File
    {
        return $this->createMock(File::class);
    }
}
