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
     * @param GeneratedFile $file
     * @param MappingCollection|Mapping[] $mappings
     * @param int $version
     */
    public function __construct(GeneratedFile $file, MappingCollection $mappings, int $version = 3)
    {
        $this->file = $file;
        $this->mappings = $mappings;
        $this->version = $version;
    }

    /**
     * @codeCoverageIgnore
     * @return MappingCollection|Mapping[]
     */
    public function mappings(): MappingCollection
    {
        return $this->mappings;
    }
}
