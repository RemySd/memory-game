# php-routing-system
Création d'un système de routing très simple en PHP

## Installation

Clone the project

```bash
  git clone git@github.com:RemySd/sf-memory-game.git
  cd php-routing-system
```

Chager composer

```bash
  composer install
```

Créer une base de données + ajouter la config dans le fichier .env.local

```bash
  bin/console doctrine:schema:update -f
```

## Deployment

To deploy this project run

```bash
  php -S localhost:8000 -t .
```

how go to http://localhost:8000/
