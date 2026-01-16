<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception thrown when a user attempts to access resources without proper authorization
 * 
 * This exception is used to enforce access control for uninvited users attempting to
 * access the registration system or assessment materials.
 * Requirements: 5.5, 6.2, 6.3, 12.2
 */
class UnauthorizedAccessException extends Exception
{
    /**
     * Create a new exception instance
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "Unauthorized access", int $code = 403, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
