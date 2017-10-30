<?php
declare(strict_types=1);

namespace Glagol\SourceMap;

use RuntimeException;

// @codeCoverageIgnoreStart
const SOURCE_MAP_REGEX = '@//# sourceMappingURL=(?P<file>.+?\.map)@';
// @codeCoverageIgnoreEnd

function load_map_from_generated_source(string $filePath, ?string $basePath = null): ?SourceMapFile
{
    $line = read_last_line($filePath);
    preg_match(SOURCE_MAP_REGEX, $line, $matches);

    $path = array_get($matches, 'file');

    if (is_null($path)) {
        return null;
    }

    $fullPath = $basePath . '/' . $path;

    return file_exists($fullPath) && !is_dir($fullPath) ? new SourceMapFile($fullPath) : null;
}

function read_last_line(string $filePath): string
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
