# Api Platform Con 2021 : "Unified permission management between API and client"

Voir : https://api-platform.com/con/2021/conferences/unified-permission-management-between-api-and-client/

Ce dépôt est le support de la conférence donnée à l'API Platform Con 2021.  
Il s'agit d'un **exemple** d'implémentation du système présenté (API & frontend).

Les slides sont disponibles [ici](./slides_conf.pdf).

**Cette application n'est qu'un POC et n'est absolument pas prévue pour être utilisée en production.**

## Pré-requis

- Docker
- Docker Compose
- Npm ou Yarn

Note : ce projet utilise Docker et Caddy tel que proposé dans la distribution du framework API Platform.   
Il existe cependant à l'heure actuelle un problème avec le module de hot reload (en environnement de développement) de Vitejs qui provoque des rechargements en boucle si l'application frontend est dans un conteneur Docker. Je n'utilise donc pas Docker pour l'application frontend dans ce projet, si vous avez une idée pour régler ce problème n'hésitez pas à ouvrir une PR :)

## Installation

Si besoin, configurez les variables d'environnement locales dans un fichier `api/.env.local` puis :

```bash
$ docker-compose up -d --build
```

Cette commande va construire et démarrer les conteneurs Docker pour la base de données, l'application PHP et le reverse proxy Caddy.  
Il reste à installer les dépendances du frontend et lancer le serveur de développement :

```bash
$ cd front/
$ npm install
$ npm run expose
```

La commande `expose` devrait lancer le serveur de développement de vite en exposant au réseau sur l'ip 172.18.0.1 et le port 3000.  
Si besoin cela peut être modifié mais n'oubliez pas de changer la référence dans le fichier `docker-compose.yml` (PWA_UPSTREAM) pour que Caddy puisse rediriger le trafic vers l'application frontend.

## Installation des fixtures

```bash
$ docker-compose exec php bin/console hautelook:fixtures:load
```

Les fixtures sont situées dans le dossier `api/fixtures`.

## Démonstration

L'application est disponible sur https://localhost (penser à accepter le certificat auto-signé ou ajouter le certificat root à votre navigateur), la connexion se fait grâce aux identifiants présents dans les fixtures `(api/fixtures/user.yaml)`.  
Par exemple : `president@foo.com` / `azerty`

Il est ensuite possible de modifier les permissions et les règles liées grâce à Postman par exemple, via l'API. Dans les fixtures par défaut, il faut le rôle ROLE_ADMIN pour requêter les ressources Permission et PermissionRule. Ce rôle est donné au compte "president".

Attention, la mise à jour via mercure ne se fait qu'en mettant à jour par l'API et non pas directement en base.