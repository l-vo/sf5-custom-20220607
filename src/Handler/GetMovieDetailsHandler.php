<?php

namespace App\Handler;

use App\Entity\Movie;
use App\Message\MovieTitle;
use App\Provider\MovieProvider;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final class GetMovieDetailsHandler
{
    public function __construct(
        private MovieProvider $movieProvider,
    ) {}

    public function __invoke(MovieTitle $movieTitle): Movie
    {
        return $this->movieProvider->getByTitle($movieTitle->title);
    }
}