<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    /**
     * Register a GET route
     */
    public function get(string $path, $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    /**
     * Register a POST route
     */
    public function post(string $path, $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    /**
     * Register a PUT route
     */
    public function put(string $path, $handler): void
    {
        $this->addRoute('PUT', $path, $handler);
    }

    /**
     * Register a DELETE route
     */
    public function delete(string $path, $handler): void
    {
        $this->addRoute('DELETE', $path, $handler);
    }

    /**
     * Add a route to the routes array
     */
    private function addRoute(string $method, string $path, $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
        ];
    }

    /**
     * Dispatch the request to the appropriate handler
     */
    public function dispatch(string $method, string $uri): void
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchRoute($route['path'], $uri)) {
                $this->handleRoute($route['handler'], $this->extractParams($route['path'], $uri));
                return;
            }
        }

        // No route found
        http_response_code(404);
        echo "404 - Page not found";
    }

    /**
     * Check if route path matches URI
     */
    private function matchRoute(string $routePath, string $uri): bool
    {
        // Convert route path to regex pattern
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';

        return preg_match($pattern, $uri) === 1;
    }

    /**
     * Extract route parameters from URI
     */
    private function extractParams(string $routePath, string $uri): array
    {
        $params = [];

        // Extract parameter names from route path
        preg_match_all('/\{([^}]+)\}/', $routePath, $paramNames);
        
        // Convert route path to regex and extract values
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';
        
        preg_match($pattern, $uri, $matches);
        array_shift($matches); // Remove full match

        // Combine parameter names with values
        foreach ($paramNames[1] as $index => $name) {
            if (isset($matches[$index])) {
                $params[$name] = $matches[$index];
            }
        }

        return $params;
    }

    /**
     * Handle the route
     */
    private function handleRoute($handler, array $params = []): void
    {
        if (is_string($handler)) {
            // Controller@method format
            list($controllerName, $method) = explode('@', $handler);
            
            $controllerClass = "App\\Controllers\\{$controllerName}";
            
            if (!class_exists($controllerClass)) {
                throw new \Exception("Controller not found: {$controllerClass}");
            }

            $controller = new $controllerClass();
            
            if (!method_exists($controller, $method)) {
                throw new \Exception("Method not found: {$method} in {$controllerClass}");
            }

            call_user_func_array([$controller, $method], $params);
        } elseif (is_callable($handler)) {
            // Closure
            call_user_func_array($handler, $params);
        } else {
            throw new \Exception("Invalid route handler");
        }
    }
}
