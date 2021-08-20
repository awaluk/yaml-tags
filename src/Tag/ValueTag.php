<?php

declare(strict_types=1);

namespace AWaluk\YamlTags\Tag;

class ValueTag implements TagInterface
{
    public function __construct(private $value)
    {
    }

    public function convert($input)
    {
        return $this->value;
    }
}
