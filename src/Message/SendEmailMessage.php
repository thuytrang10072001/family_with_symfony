<?php

namespace App\Message;

class SendEmailMessage
{
    public function __construct(
        private string $recipientEmail,
        private string $subject,
        private string $content
    ) {}

    public function getRecipientEmail(): string
    {
        return $this->recipientEmail;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
