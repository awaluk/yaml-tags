<?php

declare(strict_types=1);

namespace AWaluk\YamlTags\Exception;

use Exception;

class UnknownTagException extends Exception
{
    public function __construct(string $tag, string $message = 'Unknown tag "%s", use registerTag() method to add it.')
    {
        parent::__construct(sprintf($message, $tag));
    }
}
