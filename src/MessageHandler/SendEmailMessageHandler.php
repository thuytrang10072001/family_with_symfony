<?php

namespace App\MessageHandler;

use App\Message\SendEmailMessage;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendEmailMessageHandler
{
    public function __construct(private MailerInterface $mailer) {}

    public function __invoke(SendEmailMessage $message)
    {
        $email = (new Email())
            ->from('lethithuytrang20070805@gmail.com')
            ->to($message->getRecipientEmail())
            ->subject($message->getSubject())
            ->text($message->getContent());

        $this->mailer->send($email);

        echo "✅ Gửi email đến: " . $message->getRecipientEmail() . "\n";
    }
}
