<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception thrown when attempting to add an email that already exists in the system
 * 
 * This exception is used to enforce the global email uniqueness constraint across all events.
 * Requirements: 1.3, 2.4, 8.1, 8.2, 13.6
 */
class DuplicateEmailException extends Exception
{
    /**
     * Create a new exception instance
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "Email already exists in the system", int $code = 409, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
