<?php
declare(strict_types=1);

namespace Glagol\SourceMap;

class Base64VLQ
{
    private const VLQ_BASE_SHIFT = 5;
    private const VLQ_BASE = 1 << self::VLQ_BASE_SHIFT;
    private const VLQ_BASE_MASK = self::VLQ_BASE - 1;
    private const VLQ_CONTINUATION_BIT = self::VLQ_BASE;

    public static function decode(string $in): int
    {
        $result = 0;
        $shift = 0;
        $stringPosition = 0;

        do {
            $c = $in[$stringPosition];
            $digit = Base64::fromBase64($c);
            $continuation = ($digit & self::VLQ_CONTINUATION_BIT) != 0;
            $digit &= self::VLQ_BASE_MASK;
            $result = $result + ($digit << $shift);
            $shift = $shift + self::VLQ_BASE_SHIFT;
            $stringPosition++;
        } while ($continuation);

        return self::fromVLQSigned($result);
    }

    private static function fromVLQSigned(int $value): int
    {
        $negate = ($value & 1) == 1;
        $value = $value >> 1;
        return $negate ? -$value : $value;
    }
}
