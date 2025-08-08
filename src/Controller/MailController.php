<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\Notification;

final class MailController extends AbstractController
{
    #[Route('/mail', name: 'app_mail')]
    public function index(): Response
    {
        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }

    #[Route('/mail/send', name: 'app_mail_send')]
    public function controller(
        Notification $notification,
    ): Response {
        $notification->send(
            'destinaire@domaine.ext',
            'Test',
            "le contenu de la notification :\nC'est un test",
        );
        return new Response('Notification sent.');
    }
}

