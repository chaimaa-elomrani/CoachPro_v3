<?php

namespace App\Core;

class ServiceContainer
{
    private array $services = [];
    private array $singletons = [];

    /**
     * Register a service
     */
    public function register(string $name, callable $factory, bool $singleton = false): void
    {
        $this->services[$name] = [
            'factory' => $factory,
            'singleton' => $singleton,
        ];
    }

    /**
     * Get a service
     */
    public function get(string $name)
    {
        // Check if service is registered
        if (!isset($this->services[$name])) {
            throw new \Exception("Service not found: {$name}");
        }

        $service = $this->services[$name];

        // If singleton and already instantiated, return existing instance
        if ($service['singleton'] && isset($this->singletons[$name])) {
            return $this->singletons[$name];
        }

        // Create new instance
        $instance = $service['factory']($this);

        // Store singleton instance
        if ($service['singleton']) {
            $this->singletons[$name] = $instance;
        }

        return $instance;
    }

    /**
     * Check if a service is registered
     */
    public function has(string $name): bool
    {
        return isset($this->services[$name]);
    }

    /**
     * Register default services
     */
    public function registerDefaultServices(): void
    {
        // Register router as singleton
        $this->register('router', function () {
            return new Router();
        }, true);

        // Register database (optional, already singleton in Database class)
        $this->register('db', function () {
            return Database::getInstance();
        }, true);
    }
}
