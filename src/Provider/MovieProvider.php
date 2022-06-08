<?php

namespace App\Provider;

use App\Consumer\OMDbApiConsumer;
use App\Entity\Movie;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class MovieProvider
{
    public function __construct(
        private OMDbApiConsumer $consumer,
        private DenormalizerInterface $denormalizer,
    ) {}

    public function getOneMovie(string $type, string $value): Movie
    {
        return ($this->denormalizer->denormalize(
            $this->consumer->consume($type, $value),
            Movie::class,
        ));
    }

    public function getById(string $id): Movie
    {
        return $this->getOneMovie(OMDbApiConsumer::MODE_ID, $id);
    }

    public function getByTitle(string $title): Movie
    {
        return $this->getOneMovie(OMDbApiConsumer::MODE_TITLE, $title);
    }
}