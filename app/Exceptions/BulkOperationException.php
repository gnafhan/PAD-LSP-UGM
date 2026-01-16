<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception thrown when a bulk operation fails
 * 
 * This exception is used when bulk participant additions fail due to validation errors,
 * duplicates, or other issues that prevent the entire batch from being processed.
 * Requirements: 2.5, 2.6, 2.8, 13.3, 13.4
 */
class BulkOperationException extends Exception
{
    /**
     * Create a new exception instance
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "Bulk operation failed", int $code = 422, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
