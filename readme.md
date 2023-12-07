# sf-memory-game
Création du jeu memories en PHP avec le framework Symfony

## Installation

Clone the project

```bash
  git clone git@github.com:RemySd/sf-memory-game.git
  cd sf-memory-game
```

Charger composer

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
  symfony serve
```

Go to https://127.0.0.1:8000  
