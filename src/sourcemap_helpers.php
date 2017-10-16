<?php
declare(strict_types=1);

namespace Glagol\SourceMap;

use RuntimeException;

// @codeCoverageIgnoreStart
const SOURCE_MAP_REGEX = '@//# sourceMappingURL=(?P<file>.+?\.map)@';
// @codeCoverageIgnoreEnd

function gdebug_get_source_map_path(string $filePath): ?string
{
    $line = gdebug_read_last_line($filePath);
    preg_match(SOURCE_MAP_REGEX, $line, $matches);

    return array_get($matches, 'file');
}

function gdebug_read_last_line(string $filePath): string
{
    if (!file_exists($filePath)) {
        throw new RuntimeException("File '{$filePath}' does not exist");
    }

    $line = '';

    $f = fopen($filePath, 'r');
    $cursor = -1;

    fseek($f, $cursor, SEEK_END);
    $char = fgetc($f);

    while ($char === "\n" || $char === "\r") {
        fseek($f, $cursor--, SEEK_END);
        $char = fgetc($f);
    }

    while ($char !== false && $char !== "\n" && $char !== "\r") {
        $line = $char . $line;
        fseek($f, $cursor--, SEEK_END);
        $char = fgetc($f);
    }

    return $line;
}
