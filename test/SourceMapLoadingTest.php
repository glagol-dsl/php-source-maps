<?php
declare(strict_types=1);

namespace GlagolTest\SourceMap;

use function Glagol\SourceMap\has_source_map;
use function Glagol\SourceMap\load_map_from_generated_source;
use function Glagol\SourceMap\read_last_line;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class SourceMapLoadingTest extends TestCase
{
    public function testShouldGetLastLineFromAFile()
    {
        $line = read_last_line(__DIR__ . '/file_with_sourcemap_comment.php');
        self::assertEquals('//# sourceMappingURL=test_source.map', $line);
    }

    public function testShouldThrowExceptionWhenFileDoesNotExist()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('File \'' . __DIR__ . '/i_do_not_exist.php' . '\' does not exist');
        read_last_line(__DIR__ . '/i_do_not_exist.php');
    }

    public function testShouldReturnNull()
    {
        $path = load_map_from_generated_source(__DIR__ . '/file_with_sourcemap_comment.php', __DIR__);
        self::assertNotNull($path);
    }

    public function testShouldReturnNullWhenFileDoesNotHaveSourceMapComment()
    {
        $path = load_map_from_generated_source(__FILE__, __DIR__);
        self::assertEquals(null, $path);
    }

    public function testHasSourceMapShouldReturnTrueOnExistingSourceMap()
    {
        self::assertTrue(has_source_map(__DIR__ . '/file_with_sourcemap_comment.php', __DIR__));
    }

    public function testHasSourceMapShouldReturnFalseOnNonExistingSourceMap()
    {
        self::assertFalse(has_source_map(__FILE__, __DIR__));
    }
}
