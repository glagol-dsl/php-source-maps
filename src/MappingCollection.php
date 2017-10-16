<?php
declare(strict_types=1);

namespace Glagol\SourceMap;

use Illuminate\Support\Collection;

/**
 * @method Mapping first(callable $callback = null, $default = null)
 */
class MappingCollection extends Collection
{
    public function findByGeneratedLine(int $line): MappingCollection {
        return $this->filter(function (Mapping $mapping) use ($line) {
            return $mapping->generatedLineEquals($line);
        });
    }
}
