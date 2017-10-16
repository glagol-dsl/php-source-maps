<?php
declare(strict_types=1);

namespace Glagol\SourceMap;

use LogicException;

class Base64
{
    private const BASE64_MAP =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZ" .
        "abcdefghijklmnopqrstuvwxyz" .
        "0123456789+/";

    private static $base64DecodeMap = [];

    private static function getBase64DecodeMap(): array
    {
        if (!self::$base64DecodeMap) {
            for ($i = 0; $i < strlen(self::BASE64_MAP); $i++) {
                self::$base64DecodeMap[self::BASE64_MAP[$i]] = $i;
            }
        }

        return self::$base64DecodeMap;
    }

    public static function fromBase64(string $encodedDigit): int
    {
        $base64DecodeMap = self::getBase64DecodeMap();

        if (!array_key_exists($encodedDigit, $base64DecodeMap)) {
            throw new LogicException("Invalid base64 digit: {$encodedDigit}");
        }

        return $base64DecodeMap[$encodedDigit];
    }
}
