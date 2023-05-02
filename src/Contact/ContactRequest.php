<?php

namespace App\Contact;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactRequest
{
    public function __construct(
        private MailerInterface $mailer,
        private string $adminEmail
    ) {
    }

    public function send(array $data): void
    {
        $email = new Email();

        $email->from($data['Email'])
            ->to($this->adminEmail)
            ->subject('Demande de contact de ' . $data['Nom'])
            ->text($data['Message']);

        $this->mailer->send($email);
    }
}
