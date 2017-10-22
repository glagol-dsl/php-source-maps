<?php
declare(strict_types=1);

namespace Glagol\SourceMap;

use Illuminate\Support\Collection;

/**
 * @method Mapping first(callable $callback = null, $default = null)
 */
class MappingCollection extends Collection
{
    public function filterByGeneratedLine(int $line): self
    {
        return $this->filter(function (Mapping $mapping) use ($line) {
            return $mapping->isGeneratedLineEqualTo($line);
        });
    }

    public function filterByName(string $name): self
    {
        return $this->filter(function (Mapping $mapping) use ($name) {
            return $mapping->isNameEqualTo($name);
        });
    }
}
