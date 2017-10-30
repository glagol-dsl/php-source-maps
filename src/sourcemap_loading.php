<?php
declare(strict_types=1);

namespace Glagol\SourceMap;

use RuntimeException;

// @codeCoverageIgnoreStart
const SOURCE_MAP_REGEX = '@//# sourceMappingURL=(?P<file>.+?\.map)@';
// @codeCoverageIgnoreEnd

function has_source_map(string $filePath, string $basePath): bool
{
    $mapPath = lookup_source_map_path($filePath);

    if (is_null($mapPath)) {
        return false;
    }

    $fullMapFile = $basePath . '/' . $mapPath;

    return !is_null($mapPath) && file_exists($fullMapFile) && !is_dir($fullMapFile);
}

function load_map_from_generated_source(string $filePath, string $basePath): ?SourceMapFile
{
    $path = lookup_source_map_path($filePath);

    if (is_null($path)) {
        return null;
    }

    $fullPath = $basePath . '/' . $path;

    return file_exists($fullPath) && !is_dir($fullPath) ? new SourceMapFile($fullPath) : null;
}

/**
 * @param string $filePath
 * @return null|string
 */
function lookup_source_map_path(string $filePath): ?string
{
    static $cache = [];

    if (array_key_exists($filePath, $cache)) {
        return array_get($cache, $filePath);
    }

    $line = read_last_line($filePath);
    preg_match(SOURCE_MAP_REGEX, $line, $matches);

    $mapPath = array_get($matches, 'file');

    $cache[$filePath] = $mapPath;

    return $mapPath;
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
