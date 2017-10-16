<?php
declare(strict_types=1);

namespace GlagolTest\SourceMap;

use function Glagol\SourceMap\gdebug_get_source_map_path;
use function Glagol\SourceMap\gdebug_read_last_line;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class SourceMapHelpersTest extends TestCase
{
    public function testShouldGetLastLineFromAFile()
    {
        $line = gdebug_read_last_line(__DIR__ . '/file_with_sourcemap_comment.php');
        self::assertEquals('//# sourceMappingURL=source_maps/Example/UserController.php.map', $line);
    }

    public function testShouldThrowExceptionWhenFileDoesNotExist()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('File \'' . __DIR__ . '/i_do_not_exist.php' . '\' does not exist');
        gdebug_read_last_line(__DIR__ . '/i_do_not_exist.php');
    }

    public function testShouldGetSourceMapFilePath()
    {
        $path = gdebug_get_source_map_path(__DIR__ . '/file_with_sourcemap_comment.php');
        self::assertEquals('source_maps/Example/UserController.php.map', $path);
    }

    public function testShouldReturnNullWhenFileDoesNotHaveSourceMapComment()
    {
        $path = gdebug_get_source_map_path(__FILE__);
        self::assertEquals(null, $path);
    }
}
