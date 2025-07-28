<?php

namespace App\Controller;

use App\Message\SendEmailMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;

class TestController extends AbstractController
{
    #[Route('/send-email-test', name: 'send_email_test')]
    public function sendEmailTest(MessageBusInterface $bus): Response
    {
        $message = new SendEmailMessage(
            'myloveisyoona530@gmail.com',
            'Chủ đề thử nghiệm',
            'Đây là nội dung của email được gửi qua Redis Messenger!'
        );

        $bus->dispatch($message);

        return new Response('✅ Đã gửi message vào queue.');
    }
}
