# Docker avec Vite - Guide d'utilisation

## Production (par défaut)

Les assets sont automatiquement compilés lors du démarrage du conteneur `app` :

```bash
docker-compose up -d
```

Le service `app` exécute automatiquement :
1. `composer install`
2. `npm ci` (installation des dépendances npm)
3. `npm run build` (compilation des assets pour la production)
4. `php artisan migrate`
5. `php-fpm`

Les assets compilés sont dans `public/build/` et servis directement par Nginx.

## Développement avec Hot Reload

Pour utiliser le serveur de développement Vite avec hot reload :

```bash
# Démarrer tous les services + Vite dev server
docker-compose --profile dev up -d

# Ou seulement le service Vite
docker-compose up -d vite
```

Le service `vite` :
- Écoute sur le port `5173`
- Surveille les changements dans `resources/css/` et `resources/js/`
- Recompile automatiquement les assets
- Supporte le Hot Module Replacement (HMR)

### Configuration

Le fichier `vite.config.js` est configuré pour :
- Écouter sur `0.0.0.0:5173` (accessible depuis Docker)
- HMR configuré pour `localhost` (pour le navigateur)

### Volumes

- `node_modules` : Volume Docker pour éviter de réinstaller les dépendances à chaque démarrage
- Les fichiers source sont montés depuis votre machine locale

## Commandes utiles

### Recompiler les assets en production
```bash
docker-compose exec app npm run build
```

### Voir les logs du serveur Vite
```bash
docker-compose logs -f vite
```

### Arrêter le serveur Vite
```bash
docker-compose stop vite
```

### Reconstruire après modification de package.json
```bash
docker-compose exec app npm ci
docker-compose exec app npm run build
```

## Notes

- En production, le service `vite` n'est pas nécessaire (assets précompilés)
- En développement, utilisez `--profile dev` pour activer le service Vite
- Les `node_modules` sont dans un volume séparé pour de meilleures performances

