<?php

namespace App\Message;

final class SendEmailMessage
{
    public function __construct(
        public readonly string $recipient,
        public readonly string $message,
    ) {}
}