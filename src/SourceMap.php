<?php
declare(strict_types=1);

namespace Glagol\SourceMap;


class SourceMap
{
    /**
     * @var File
     */
    private $file;

    /**
     * @var int
     */
    private $version;

    /**
     * @var Mapping[]|MappingCollection
     */
    private $mappings;

    /**
     * SourceMap constructor.
     *
     * @param File $file
     * @param MappingCollection|Mapping[] $mappings
     * @param int $version
     */
    public function __construct(File $file, MappingCollection $mappings, int $version = 3)
    {
        $this->file = $file;
        $this->mappings = $mappings;
        $this->version = $version;
    }

    /**
     * @return MappingCollection|Mapping[]
     */
    public function mappings(): MappingCollection
    {
        return $this->mappings;
    }

    /**
     * @param string $map
     * @return SourceMap
     */
    public static function createFromJson(string $map): self {
        $map = json_decode($map, true);

        $sources = array_map(function (string $path) {
            return new File($path);
        }, array_get($map, 'sources', []));

        $names = array_get($map, 'names', []);

        $file = new File($map['file']);

        $mappings = new MappingCollection(mappings_parse(array_get($map, 'mappings', ''), $sources, $names));

        $version = (int) array_get($map, 'version', 3);

        return new self($file, $mappings, $version);
    }

    /**
     * @param string $mapFile
     * @return SourceMap
     */
    public static function createFromFile(string $mapFile): self {
        return self::createFromJson(file_get_contents($mapFile));
    }
}
