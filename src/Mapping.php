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
    private $originalName;

    /**
     * @param int $generatedLine
     * @param int $generatedColumn
     * @param File $originalSource
     * @param int $originalLine
     * @param int $originalColumn
     * @param string $originalName
     */
    public function __construct(
        int $generatedLine, int $generatedColumn,
        File $originalSource, int $originalLine, int $originalColumn, ?string $originalName = null)
    {
        $this->generatedLine = $generatedLine;
        $this->generatedColumn = $generatedColumn;
        $this->originalSource = $originalSource;
        $this->originalLine = $originalLine;
        $this->originalColumn = $originalColumn;
        $this->originalName = $originalName;
    }

    public function generatedLineEquals(int $line): bool
    {
        return $line === $this->generatedLine;
    }
}
