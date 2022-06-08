<?php

namespace App\Controller;

use App\Message\SendEmailMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class MessengerController extends AbstractController
{
    #[Route('/send-email')]
    public function sendMail(MessageBusInterface $messageBus): Response
    {
        $messageBus->dispatch(new SendEmailMessage('me@example.com', 'Hello !'));

        return new Response('<body></body>');
    }
}