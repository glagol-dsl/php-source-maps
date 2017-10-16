<?php
declare(strict_types=1);

namespace GlagolTest\SourceMap;

use Glagol\SourceMap\Base64VLQ;
use PHPUnit\Framework\TestCase;

class Base64VLQTest extends TestCase
{
    public function testShouldDecodeCapitalAAsZero()
    {
        self::assertSame(0, Base64VLQ::decode('A'));
    }

    public function testShouldDecodeCapitalZAsMinus12()
    {
        self::assertSame(-12, Base64VLQ::decode('Z'));
    }

    public function testShouldDecodeUsingContinuationBit()
    {
        self::assertSame(1552, Base64VLQ::decode('ghD'));
    }

    public function testShouldThrowExceptionWhenDecodingInvalidChar()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage("Invalid base64 digit: (");
        Base64VLQ::decode('(');
    }
}
