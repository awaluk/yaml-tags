<?php

declare(strict_types=1);

namespace AWaluk\YamlTags\Tag;

interface TagInterface
{
    public function convert($input);
}
