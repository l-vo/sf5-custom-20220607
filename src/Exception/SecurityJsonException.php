<?php

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class SecurityJsonException extends AuthenticationException
{
    public function getMessageKey(): string
    {
        return 'undecodable_or_empty_json';
    }
}