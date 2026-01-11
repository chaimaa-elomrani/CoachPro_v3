# Guide de Démarrage Rapide - CoachPro v3

## Structure créée ✅

L'architecture MVC avec Service Container a été créée avec succès. Voici ce qui a été mis en place :

### 📁 Structure des Répertoires

```
coachpro_v3/
├── app/
│   ├── config/              # Configuration des routes
│   ├── Controllers/         # Contrôleurs MVC
│   ├── Core/                # Classes core (Router, Database, ServiceContainer, etc.)
│   ├── helpers/             # Fonctions utilitaires
│   ├── Middleware/          # Middlewares (Auth, etc.)
│   ├── Models/              # Modèles (optionnel, Repository Pattern préféré)
│   ├── Repositories/        # Repositories (accès aux données)
│   ├── Services/            # Services métier
│   └── Views/               # Templates de vues
├── docs/                    # Documentation
├── public/                  # Fichiers publics (CSS, JS, assets)
├── index.php                # Point d'entrée unique
├── composer.json            # Dépendances
├── .htaccess                # Configuration Apache
└── README.md                # Documentation principale
```

### 🔧 Composants Principaux

1. **Service Container** (`app/Core/ServiceContainer.php`)
   - Gestion des dépendances
   - Injection de dépendances
   - Support des singletons
   - Autowiring basique

2. **Router** (`app/Core/Router.php`)
   - Routing dynamique
   - Support des paramètres de route {id}
   - Middlewares
   - Méthodes HTTP (GET, POST, PUT, DELETE)

3. **Database** (`app/Core/Database.php`)
   - Singleton pour la connexion PostgreSQL
   - Utilisation de PDO avec requêtes préparées
   - Support des transactions

4. **Config** (`app/Core/Config.php`)
   - Chargement des variables d'environnement (.env)
   - Accès simple aux configurations

5. **Controller Base** (`app/Core/Controller.php`)
   - Méthodes utilitaires (render, json, redirect)
   - Validation de formulaire
   - Protection CSRF
   - Échappement XSS

6. **Repository Pattern**
   - `RepositoryInterface` : Interface de base
   - `BaseRepository` : Implémentation CRUD de base

## 🚀 Prochaines Étapes

### 1. Installation des Dépendances

```bash
composer install
```

### 2. Configuration de l'Environnement

Créer un fichier `.env` à partir de `.env.example` :

```env
APP_NAME=CoachPro
APP_ENV=development
APP_DEBUG=true

DB_HOST=localhost
DB_PORT=5432
DB_NAME=coachpro_db
DB_USER=postgres
DB_PASSWORD=votre_mot_de_passe
```

### 3. Création de la Base de Données

Exécuter le script SQL dans `docs/DATABASE_SCHEMA.sql` :

```bash
psql -U postgres -d coachpro_db -f docs/DATABASE_SCHEMA.sql
```

### 4. Développement des Fonctionnalités

Suivre l'ordre suivant :

1. **Repositories** (accès aux données)
   - `CoachRepository`
   - `SportifRepository`
   - `SeanceRepository`
   - `ReservationRepository`

2. **Services** (logique métier)
   - `AuthService`
   - `CoachService`
   - `SeanceService`
   - `ReservationService`

3. **Middlewares**
   - `AuthMiddleware`
   - `CoachMiddleware`
   - `SportifMiddleware`

4. **Contrôleurs**
   - `AuthController`
   - `CoachController`
   - `SeanceController`
   - `ReservationController`

5. **Vues**
   - Templates pour chaque fonctionnalité

## 📝 Exemple d'Utilisation

### Enregistrer un Service dans le Container

```php
// Dans ServiceContainer::registerDefaultServices()
$container->set('App\Repositories\CoachRepository', function($container) {
    return new App\Repositories\CoachRepository();
}, true);

$container->set('App\Services\CoachService', function($container) {
    $repo = $container->get('App\Repositories\CoachRepository');
    return new App\Services\CoachService($repo);
}, true);
```

### Définir une Route

```php
// Dans app/config/routes.php
$router->get('/coachs', 'CoachController@index');
$router->get('/coachs/{id}', 'CoachController@show');
$router->post('/coachs', 'CoachController@store', ['AuthMiddleware', 'CoachMiddleware']);
```

### Utiliser dans un Contrôleur

```php
namespace App\Controllers;

use App\Core\Controller;

class CoachController extends Controller
{
    public function index(): void
    {
        $coachService = $this->get('App\Services\CoachService');
        $coachs = $coachService->getAllCoachs();
        
        $this->render('coach/index', ['coachs' => $coachs]);
    }
}
```

## ✅ Checklist de Développement

- [x] Structure MVC créée
- [x] Service Container implémenté
- [x] Router dynamique fonctionnel
- [x] Database abstraction (PDO)
- [x] Repository Pattern (interfaces et base)
- [x] Configuration système
- [x] Helpers et fonctions utilitaires
- [x] Templates de base (header, footer)
- [ ] Repositories pour les entités
- [ ] Services métier
- [ ] Middlewares d'authentification
- [ ] Contrôleurs complets
- [ ] Vues complètes
- [ ] Validation et sécurité
- [ ] Tests (optionnel)

## 📚 Documentation

- `README.md` : Documentation principale
- `docs/STRUCTURE.md` : Structure détaillée des entités
- `docs/DATABASE_SCHEMA.sql` : Schéma de base de données
- `docs/SERVICE_CONTAINER_EXAMPLE.php` : Exemples d'utilisation du Service Container

## 🎯 Bonnes Pratiques

1. **SOLID Principles** : Respecter les principes SOLID
2. **DRY** : Ne pas se répéter
3. **Separation of Concerns** : Séparation claire des responsabilités
4. **Security** : Validation, CSRF, XSS protection
5. **Error Handling** : Gestion appropriée des erreurs
6. **Code Documentation** : Commenter le code complexe

---

**Prêt pour la phase 2 !** 🚀