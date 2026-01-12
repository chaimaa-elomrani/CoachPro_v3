<?php

namespace App\Middleware;

interface MiddlewareInterface
{
    /**
     * Handle the middleware
     */
    public function handle(): void;
}
