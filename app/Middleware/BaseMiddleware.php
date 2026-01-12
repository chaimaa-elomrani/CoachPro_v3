<?php

namespace App\Middleware;

abstract class BaseMiddleware implements MiddlewareInterface
{
    /**
     * Base middleware class
     * Extend this class to create custom middleware
     */
    
    public function handle(): void
    {
        // Override this method in your middleware classes
    }
}
