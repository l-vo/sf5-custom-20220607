<?php

namespace App\Serializer;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

final class PascalCaseNameConverter implements NameConverterInterface
{
    public function normalize(string $propertyName): string
    {
        return ucfirst($propertyName);
    }

    public function denormalize(string $propertyName): string
    {
        return lcfirst($propertyName);
    }
}