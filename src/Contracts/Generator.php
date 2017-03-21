<?php

namespace Gravure\Verification\Contracts;

interface Generator
{
    /**
     * Generate a unique string.
     *
     * @return string
     */
    public function generate(): string;
}
