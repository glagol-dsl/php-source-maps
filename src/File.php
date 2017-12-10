<?php
declare(strict_types=1);

namespace Glagol\SourceMap;

abstract class File
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function toPath(string $basePath): string
    {
        $basePath = rtrim($basePath, "/\\");
        $path = ltrim($this->path, "/\\");

        return "{$basePath}/{$path}";
    }
}
