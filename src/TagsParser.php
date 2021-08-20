<?php

declare(strict_types=1);

namespace AWaluk\YamlTags;

use AWaluk\YamlTags\Exception\UnknownTagException;
use Symfony\Component\Yaml\Tag\TaggedValue;

class TagsParser
{
    public function __construct(private array $tags)
    {
    }

    public function convertTags($input)
    {
        if (!is_array($input)) {
            $tag = $this->getIfContainsKnownTag($input);
            if ($tag !== null) {
                $input = $tag->convert($input->getValue());
            }

            return $input;
        }

        foreach ($input as &$item) {
            $tag = $this->getIfContainsKnownTag($item);
            if ($tag !== null) {
                $item = $tag->convert($item->getValue());
            } elseif (is_array($item)) {
                $item = $this->convertTags($item);
            }
        }

        return $input;
    }

    private function getIfContainsKnownTag($item)
    {
        if (!$item instanceof TaggedValue) {
            return null;
        }

        if (!isset($this->tags[$item->getTag()])) {
            throw new UnknownTagException($item->getTag());
        }

        return $this->tags[$item->getTag()];
    }
}
