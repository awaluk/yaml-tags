<?php

declare(strict_types=1);

namespace AWaluk\YamlTags\Tag;

use AWaluk\YamlTags\YamlTags;

class IncludeFileTag implements TagInterface
{
    public function __construct(private YamlTags $yaml)
    {
    }

    public function convert($input)
    {
        return $this->yaml->parseFile($input);
    }
}
