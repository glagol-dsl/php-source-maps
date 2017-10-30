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
     * @var OriginalFile
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
     * @param OriginalFile $originalSource
     * @param int $originalLine
     * @param int $originalColumn
     * @param string $name
     */
    public function __construct(
        int $generatedLine, int $generatedColumn,
        OriginalFile $originalSource, int $originalLine, int $originalColumn, ?string $name = null)
    {
        $this->generatedLine = $generatedLine;
        $this->generatedColumn = $generatedColumn;
        $this->originalSource = $originalSource;
        $this->originalLine = $originalLine;
        $this->originalColumn = $originalColumn;
        $this->name = null === $name ? null : trim($name);
    }

    public function isNameEqualTo(string $name): bool
    {
        return $name === $this->name;
    }

    public function isGeneratedLineEqualTo(int $line): bool
    {
        return $line === $this->generatedLine;
    }

    /**
     * @codeCoverageIgnore
     * @return OriginalFile
     */
    public function getOriginalSource(): OriginalFile
    {
        return $this->originalSource;
    }

    /**
     * @codeCoverageIgnore
     * @return int
     */
    public function getOriginalLine(): int
    {
        return $this->originalLine;
    }

    /**
     * @codeCoverageIgnore
     * @return int
     */
    public function getOriginalColumn(): int
    {
        return $this->originalColumn;
    }

    /**
     * @codeCoverageIgnore
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}
