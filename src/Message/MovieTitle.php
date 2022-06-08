<?php

namespace App\Message;

final class MovieTitle
{
    public function __construct(
        public readonly string $title,
    ) {}
}