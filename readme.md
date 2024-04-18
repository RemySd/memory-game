![CircleCI](https://img.shields.io/circleci/build/github/RemySd/memory-game/master)
![GitHub License](https://img.shields.io/github/license/RemySd/memory-game)
[![Symfony Version](https://img.shields.io/badge/Symfony-7.x-informational?style=flat&logo=symfony)](https://symfony.com/)
[![PHP Version](https://img.shields.io/badge/PHP-8.1-blueviolet?style=flat&logo=php)](https://www.php.net/)


# sf-memory-game
Creation of the memory game in PHP with the Symfony framework.

Live in prod => [memory.artixelpgames.com](https://memory.artixelpgames.com/)

## Installation

Clone the project

```bash
  git clone git@github.com:RemySd/sf-memory-game.git
  cd sf-memory-game
```

Load composer

```bash
  composer install
```

Create a database and setup your configuration in the .env.local file

```bash
  bin/console doctrine:schema:update -f
```

## Deployment

To deploy this project run

```bash
  symfony serve
```

Go to https://127.0.0.1:8000
