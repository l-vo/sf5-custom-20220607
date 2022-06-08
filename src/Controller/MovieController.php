<?php

namespace App\Controller;

use App\Message\MovieTitle;
use App\Security\Voter\MovieRatingVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie', name: 'app_movie_')]
class MovieController extends AbstractController
{
    #[Route('', name: 'home')]
    public function index()
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    #[Route('/{title}', name: 'details')]
    public function details(string $title, MessageBusInterface $queryBus): Response
    {
        $envelope = $queryBus->dispatch(new MovieTitle($title));

        $handledStamp = $envelope->last(HandledStamp::class);
        $movie = $handledStamp->getResult();

        $this->denyAccessUnlessGranted(MovieRatingVoter::RATING, $movie);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }
}
