<?php
declare(strict_types=1);

namespace GlagolTest\SourceMap;

use function Glagol\SourceMap\load_map_from_generated_source;
use function Glagol\SourceMap\read_last_line;
use Glagol\SourceMap\SourceMapNotFoundException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class SourceMapHelpersTest extends TestCase
{
    public function testShouldGetLastLineFromAFile()
    {
        $line = read_last_line(__DIR__ . '/file_with_sourcemap_comment.php');
        self::assertEquals('//# sourceMappingURL=source_maps/Example/UserController.php.map', $line);
    }

    public function testShouldThrowExceptionWhenFileDoesNotExist()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('File \'' . __DIR__ . '/i_do_not_exist.php' . '\' does not exist');
        read_last_line(__DIR__ . '/i_do_not_exist.php');
    }

    public function testShouldThrowExceptionWhenSourceMapFileDoesNotExist()
    {
        $path = load_map_from_generated_source(__DIR__ . '/file_with_sourcemap_comment.php');
        self::assertEquals(null, $path);
    }

    public function testShouldReturnNullWhenFileDoesNotHaveSourceMapComment()
    {
        $path = load_map_from_generated_source(__FILE__);
        self::assertEquals(null, $path);
    }
}
