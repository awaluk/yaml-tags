<?php

declare(strict_types=1);

namespace AWaluk\YamlTags\Tag;

use AWaluk\YamlTags\YamlTags;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class IncludeDirectoryTag implements TagInterface
{
    public function __construct(private YamlTags $yaml, private bool $recursive = false, private bool $asArray = true)
    {
    }

    public function convert($input)
    {
        $items = [];
        $files = new RecursiveDirectoryIterator($input, FilesystemIterator::SKIP_DOTS);
        if ($this->recursive === true) {
            $files = new RecursiveIteratorIterator($files);
        }

        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }
            $parsed = $this->yaml->parseFile($file->getPathname());

            if ($this->asArray === true) {
                $items[] = $parsed;
            } else {
                $items = array_merge($items, $parsed);
            }
        }

        return $items;
    }
}
