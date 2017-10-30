<?php
declare(strict_types=1);

namespace GlagolTest\SourceMap;

use Glagol\SourceMap\File;
use Glagol\SourceMap\GeneratedFile;
use Glagol\SourceMap\Mapping;
use Glagol\SourceMap\MappingCollection;
use Glagol\SourceMap\OriginalFile;
use Glagol\SourceMap\SourceMap;
use Glagol\SourceMap\SourceMapFile;
use PHPUnit\Framework\TestCase;

class SourceMapTest extends TestCase
{
    public function testShouldParseAFileSourceMap()
    {
        $actualSourceMap = (new SourceMapFile(__DIR__ . '/test_source.map'))->sourceMap();

        $sourceMap = $this->expectedSourceMap();

        self::assertEquals($sourceMap, $actualSourceMap);
    }

    /**
     * @return SourceMap
     */
    private function expectedSourceMap(): SourceMap
    {
        $expectedSource = new OriginalFile('/original.source');

        return new SourceMap(
            new GeneratedFile('Example/UserController.php'),
            new MappingCollection([
                new Mapping(1, 0, $expectedSource, 1, 0),
                new Mapping(2, 0, $expectedSource, 1, 0),
                new Mapping(4, 0, $expectedSource, 1, 10),
                new Mapping(8, 0, $expectedSource, 3, 0),
                new Mapping(13, 4, $expectedSource, 5, 4),
                new Mapping(13, 12, $expectedSource, 5, 4),
                new Mapping(13, 18, $expectedSource, 5, 26),
                new Mapping(17, 15, $expectedSource, 7, 12),
                new Mapping(17, 19, $expectedSource, 7, 16),
                new Mapping(17, 25, $expectedSource, 7, 22),
                new Mapping(17, 27, $expectedSource, 7, 24),
            ])
        );
    }
}
