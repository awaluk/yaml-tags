<?php

declare(strict_types=1);

namespace AWaluk\YamlTags;

use AWaluk\YamlTags\Tag\TagInterface;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;

class YamlTags
{
    private Parser $parser;
    private Dumper $dumper;

    private array $tags = [];

    public function __construct(private int $flags = 0, private int $inline = 2, private int $indent = 4)
    {
        $this->flags = $flags | Yaml::PARSE_CUSTOM_TAGS;

        $this->parser = new Parser();
        $this->dumper = new Dumper($this->indent);
    }

    public function registerTag(string $name, TagInterface $tag)
    {
        $this->tags[$name] = $tag;
    }

    public function unregisterTag(string $name)
    {
        unset($this->tags[$name]);
    }

    public function parse(string $input)
    {
        $result = $this->parser->parse($input, $this->flags);

        return (new TagsParser($this->tags))->convertTags($result);
    }

    public function parseFile(string $filename)
    {
        $result = $this->parser->parseFile($filename, $this->flags);

        return (new TagsParser($this->tags))->convertTags($result);
    }

    public function dump($input): string
    {
        return $this->dumper->dump($input, $this->inline, 0, $this->flags);
    }

    public function dumpToFile(string $filename, $input): bool
    {
        return file_put_contents($filename, $this->dump($input)) !== false;
    }
}
