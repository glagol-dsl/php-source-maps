<?php
declare(strict_types=1);

namespace Glagol\SourceMap;

use Closure;

class SourceMapFile
{
    /**
     * @var SourceMap
     */
    private $sourceMap;

    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new SourceMapNotFoundException("Cannot find source map file {$path}");
        }

        $this->sourceMap = $this->loadSourceMap($path);
    }

    public function sourceMap(): SourceMap
    {
        return $this->sourceMap;
    }

    private function loadSourceMap(string $path): SourceMap
    {
        $map = $this->readJson($path);

        $file = $this->lookupFile($map);
        $mappings = $this->buildMappingCollection($map);
        $version = $this->lookupVersion($map);

        return new SourceMap($file, $mappings, $version);
    }

    private function readJson(string $path): array
    {
        return json_decode(file_get_contents($path), true);
    }

    private function sourceFactory(): Closure
    {
        return function (string $path) {
            return new OriginalFile($path);
        };
    }

    private function collectSources(array $map): array
    {
        return array_map($this->sourceFactory(), array_get($map, 'sources', []));
    }

    private function collectNames(array $map): array
    {
        return array_get($map, 'names', []);
    }

    private function lookupFile(array $map): GeneratedFile
    {
        return new GeneratedFile(array_get($map, 'file'));
    }

    private function buildMappingCollection(array $map): MappingCollection
    {
        $sources = $this->collectSources($map);
        $names = $this->collectNames($map);

        $encodedMappings = array_get($map, 'mappings', '');
        return new MappingCollection(mappings_parse($encodedMappings, $sources, $names));
    }

    private function lookupVersion(array $map): int
    {
        return (int) array_get($map, 'version', 3);
    }
}
