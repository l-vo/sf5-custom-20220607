<?php

namespace App\Controller;

use App\Entity\Book;
use App\Events\BookEvent;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[Route('/book', name: 'app_book_')]
class BookController extends AbstractController
{
    #[Route('/{page<\d+>?1}', name: 'index')]
    public function index(int $page, BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, BookRepository $repository, EventDispatcherInterface $dispatcher): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($book);
            $dispatcher->dispatch(new BookEvent($book), BookEvent::NAME);
            $this->addFlash('success', 'New book published');

            return $this->redirectToRoute('app_book_create');
        }

        return $this->renderForm('book/create.html.twig', [
            'book_form' => $form,
        ]);
    }

    #[Route('/details/{id}', 'details')]
    public function displayBook(Book $book): Response
    {
        return $this->render('book/details.html.twig', ['book' => $book]);
    }

    #[Route('/details/{id}/transition/{transition}', 'details_state')]
    public function changeState(Book $book, string $transition, WorkflowInterface $bookStateMachine, EntityManagerInterface $em): RedirectResponse
    {
        $bookStateMachine->apply($book, $transition);
        $em->flush();

        return $this->redirectToRoute('app_book_details', ['id' => $book->getId()]);
    }
}
