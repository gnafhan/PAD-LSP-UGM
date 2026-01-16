<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception thrown when an email address fails format validation
 * 
 * This exception is used to enforce proper email format validation.
 * Requirements: 2.4, 13.1, 13.2
 */
class InvalidEmailException extends Exception
{
    /**
     * Create a new exception instance
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "Invalid email format", int $code = 422, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
