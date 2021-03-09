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
Pour installer le projet, il vous suffit de faire un clone de ce répertoire Git, puis d'exécuter ces commandes :
    
    git clone https://github.com/arthurmadecprevost/mini-projet-devweb.git
    composer install
    yarn install
Toutes les dépendances sont désormais installées. 
### Base de données
Vous devez configurer le **.env.sample** en le dupliquant et en le renommant **.env** et en remplaçant les identifiants par ceux de votre base de données.

Une fois les identifiants modifiés, vous pouvez **vérifier** que le schema de votre base est bien mappé avec la commande :
    
    php bin/console doctrine:schema:validate
Doctrine (qui est une dépendance de notre projet) va alors s'occuper de créer les tables pour vous avec la commande suivante :

    php bin/console doctrine:schema:update --force

Vous pouvez voir le détail des requêtes SQL avec la commande :

    php bin/console doctrine:schema:update --dump-sql

## Développement
Lors du développement sur le projet, vous aurez peut-être besoin de ces commandes:

    yarn build
Pour compiler le CSS et le JS de Webpack Encore.