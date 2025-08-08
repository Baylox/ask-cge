<?php

// App : nom de l'application
// Service: dossier
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

// Doit correspondre au nom du fichier
class Notification {
    public function __construct(
        // pour pouvoir utiliser le service mailer
        private MailerInterface $mailer,
    ) {}

    public function send(
        string $destinataire,
        string $subject,
        string $content,
    ) {
        $mail = new Email();
        $mail->from('no_reply@domain.ext')
            ->to($destinataire)
            ->subject("Notif $subject")
            ->text("Vous avez une nouvelle notification :\n\n$content");

        $this->mailer->send($mail);
    }
}
