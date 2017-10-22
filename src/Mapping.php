<?php
declare(strict_types=1);

namespace Glagol\SourceMap;

class Mapping
{
    /**
     * @var int
     */
    private $generatedLine;

    /**
     * @var int
     */
    private $generatedColumn;

    /**
     * @var File
     */
    private $originalSource;

    /**
     * @var int
     */
    private $originalLine;

    /**
     * @var int
     */
    private $originalColumn;

    /**
     * @var string
     */
    private $name;

    /**
     * @param int $generatedLine
     * @param int $generatedColumn
     * @param File $originalSource
     * @param int $originalLine
     * @param int $originalColumn
     * @param string $name
     */
    public function __construct(
        int $generatedLine, int $generatedColumn,
        File $originalSource, int $originalLine, int $originalColumn, ?string $name = null)
    {
        $this->generatedLine = $generatedLine;
        $this->generatedColumn = $generatedColumn;
        $this->originalSource = $originalSource;
        $this->originalLine = $originalLine;
        $this->originalColumn = $originalColumn;
        $this->name = $name;
    }

    public function isNameEqualTo(string $name): bool
    {
        return $name === $this->name;
    }

    public function isGeneratedLineEqualTo(int $line): bool
    {
        return $line === $this->generatedLine;
    }

    public function getOriginalSource(): File
    {
        return $this->originalSource;
    }

    public function getOriginalLine(): int
    {
        return $this->originalLine;
    }

    public function getOriginalColumn(): int
    {
        return $this->originalColumn;
    }
}
