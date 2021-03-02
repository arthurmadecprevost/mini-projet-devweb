# Projet Développement Web

![GitHub issues](https://img.shields.io/github/issues/arthurmadecprevost/arthurmadecprevost/mini-projet-devweb?label=issues)

****

Le Projet de Développement Web est un projet en Symfony 4.4 utilisant le squelette [website-skeleton](https://packagist.org/packages/symfony/website-skeleton#v4.4.99).
Il est connecté à une base de données relationnelle PostgreSQL.
****

- [Installation](readme.md "Installation")

****

## Installation
### Symfony
Pour installer le projet, il vous suffit de faire un clone de ce répertoire Git, puis d'executer ces commandes:
    
    composer install
    yarn install
Toutes les dépendances sont désormais installées. 
### Base de données
Vous devez configurer le .env en remplaçant les identifiants par ceux de votre base de données.

Une fois les identifiants modifiés, vous pouvez **vérifier** que le schema de votre base est bien mappé avec la commande:
    
    php bin/console doctrine:schema:validate
Doctrine (qui est une dépendance de notre projet) va alors s'occuper de créer les tables pour vous avec la commande suivante:

    php bin/console doctrine:schema:update

Vous pouvez voir le détail des requêtes SQL avec la commande:

    php bin/console doctrine:schema:update --dump-sql

