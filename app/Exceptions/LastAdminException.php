<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class LastAdminException extends Exception
{
    public function __construct(?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? 'You may not perform this action because you are the only remaining administrator.', $code, $previous);
    }
}
