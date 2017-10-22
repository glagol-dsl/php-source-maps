<?php
declare(strict_types=1);

namespace Glagol\SourceMap;

use RuntimeException;

function mappings_parse(string $encodedMappings, array $sources, ?array $names = []): array
{
    $generatedLine = 1;
    $previousGeneratedColumn = 0;
    $previousOriginalLine = 0;
    $previousOriginalColumn = 0;
    $previousSource = 0;
    $previousName = 0;
    $str = $encodedMappings;
    $end = strlen($str);
    $pos = 0;

    $mappings = [];

    while ($pos < $end) {
        if ($str[$pos] === ';') {
            $generatedLine++;
            $pos++;
            $previousGeneratedColumn = 0;
        } else if ($str[$pos] === ',') {
            $pos++;
        } else {
            $value = Base64VLQ::decode($str, $pos);
            $previousGeneratedColumn = $generatedColumn = $previousGeneratedColumn + $value;

            $originalSource = null;
            $originalLine = null;
            $originalColumn = null;
            $name = null;

            if ($pos < $end && !($str[$pos] == ',' || $str[$pos] == ';')) {
                // Original source.
                $originalSource = $sources[$previousSource += Base64VLQ::decode($str, $pos)];
                if ($pos >= $end || ($str[$pos] == ',' || $str[$pos] == ';')) {
                    throw new RuntimeException('Found a source, but no line and column');
                }
                $previousOriginalLine = $originalLine = $previousOriginalLine + Base64VLQ::decode($str, $pos);
                // Lines are stored 0-based
                $originalLine += 1;
                if ($pos >= $end || ($str[$pos] == ',' || $str[$pos] == ';')) {
                    throw new RuntimeException('Found a source and line, but no column');
                }
                // Original column.
                $previousOriginalColumn = $originalColumn = $previousOriginalColumn + Base64VLQ::decode($str, $pos);
                if ($pos < $end && !($str[$pos] == ',' || $str[$pos] == ';')) {
                    // Original name.
                    $name = array_get($names, $previousName += Base64VLQ::decode($str, $pos));
                }
            }

            $mappings[] = new Mapping(
                $generatedLine, $generatedColumn, $originalSource, $originalLine, $originalColumn, $name);
        }
    }

    return $mappings;
}
