<?php

declare(strict_types=1);

namespace AWaluk\YamlTags\Tag;

class ArrayValueTag implements TagInterface
{
    public function __construct(private array $value)
    {
    }

    public function convert($input)
    {
        return $this->value[$input] ?? null;
    }
}
