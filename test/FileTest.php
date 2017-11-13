<?php
declare(strict_types=1);

namespace GlagolTest\SourceMap;

use Glagol\SourceMap\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testShouldAppendBasePathToPathWithoutLeadingSlash()
    {
        /** @var File $file */
        $file = $this->getMockForAbstractClass(File::class, ['some/file.php']);

        $this->assertEquals('/home//some/file.php', $file->toPath('/home/'));
    }
}
