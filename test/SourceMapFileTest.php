<?php
declare(strict_types=1);

namespace GlagolTest\SourceMap;

use Glagol\SourceMap\SourceMapFile;
use Glagol\SourceMap\SourceMapNotFoundException;
use PHPUnit\Framework\TestCase;

class SourceMapFileTest extends TestCase
{
    public function testShouldThrowExceptionWhenSourceMapFileDoesNotExist()
    {
        $this->expectException(SourceMapNotFoundException::class);
        $this->expectExceptionMessage('Cannot find source map file /does_not.exist');

        new SourceMapFile('/does_not.exist');
    }
}
