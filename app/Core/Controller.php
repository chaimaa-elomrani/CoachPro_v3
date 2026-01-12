<?php

namespace App\Core;

class Controller
{
    /**
     * Render a view
     */
    protected function view(string $viewPath, array $data = []): void
    {
        // Extract data array to variables
        extract($data);

        // Get the view file path
        $viewFile = __DIR__ . '/../Views/' . str_replace('.', '/', $viewPath) . '.php';

        if (!file_exists($viewFile)) {
            throw new \Exception("View not found: {$viewPath}");
        }

        // Include the view
        require_once $viewFile;
    }

    /**
     * Return JSON response
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Redirect to a URL
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}
