<?php

namespace Gravure\Verification\Generators;

use Gravure\Verification\Contracts\Generator;
use Ramsey\Uuid\Uuid;

class UuidGenerator implements Generator
{

    /**
     * Generate a unique string.
     *
     * @return string
     */
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
