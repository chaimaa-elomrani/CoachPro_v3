<?php
/**
 * Point d'entrée unique de l'application
 * Toutes les requêtes sont redirigées vers ce fichier via .htaccess
 */

// Charger l'autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

// Démarrage de la session
session_start();

// Charger les fichiers de configuration
require_once __DIR__ . '/app/Core/Config.php';
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Core/ServiceContainer.php';
require_once __DIR__ . '/app/Core/Router.php';

// Charger les fonctions utilitaires
require_once __DIR__ . '/app/helpers/functions.php';

use App\Core\Config;
use App\Core\ServiceContainer;
use App\Core\Router;

try {
    // Initialiser la configuration
    Config::load(__DIR__ . '/.env');
    
    // Créer le conteneur de services
    $container = new ServiceContainer();
    $container->registerDefaultServices();
    
    // Créer et configurer le routeur
    $router = $container->get('router');
    
    // Passer le routeur dans les variables globales pour routes.php
    $GLOBALS['router'] = $router;
    
    // Charger les routes
    require_once __DIR__ . '/app/config/routes.php';
    
    // Récupérer l'URI de la requête (sans le query string)
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];
    
    // Dispatcher la requête
    $router->dispatch($method, $uri);
    
} catch (Exception $e) {
    // Gestion des erreurs (à améliorer avec un système de logs)
    http_response_code(500);
    echo "Erreur: " . $e->getMessage();
    if (Config::get('app.debug', false)) {
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
}