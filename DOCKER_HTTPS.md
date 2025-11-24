# Configuration HTTPS avec nginx-proxy et Let's Encrypt

## Vue d'ensemble

Ce projet utilise `nginx-proxy` avec le companion `letsencrypt` pour gérer automatiquement les certificats SSL en production.

## Configuration

### Variables d'environnement

Dans votre fichier `.env`, configurez les variables suivantes :

#### Pour le développement (HTTP uniquement)
```env
VIRTUAL_HOST=bookify.test
# Ne pas définir LETSENCRYPT_HOST et LETSENCRYPT_EMAIL
```

#### Pour la production (HTTPS avec Let's Encrypt)
```env
VIRTUAL_HOST=yourdomain.com
LETSENCRYPT_HOST=yourdomain.com
LETSENCRYPT_EMAIL=your-email@example.com
APP_URL=https://yourdomain.com
```

### Comment ça fonctionne

1. **nginx-proxy** : Reverse proxy automatique qui détecte les conteneurs avec `VIRTUAL_HOST`
2. **letsencrypt-companion** : Génère automatiquement les certificats SSL si `LETSENCRYPT_HOST` est défini
3. **nginx** : Service interne qui sert l'application Laravel
4. **app** : Service PHP-FPM qui exécute l'application

### Architecture

```
Internet → nginx-proxy (port 80/443) → nginx (port 80) → app (PHP-FPM)
```

## Utilisation

### Développement (HTTP)

1. Configurez `.env` :
```env
VIRTUAL_HOST=bookify.test
APP_URL=http://bookify.test
```

2. Ajoutez dans `/etc/hosts` :
```
127.0.0.1 bookify.test
```

3. Démarrez les services :
```bash
docker-compose up -d
```

4. Accédez à : `http://bookify.test`

### Production (HTTPS)

1. Configurez `.env` :
```env
VIRTUAL_HOST=yourdomain.com
LETSENCRYPT_HOST=yourdomain.com
LETSENCRYPT_EMAIL=admin@yourdomain.com
APP_URL=https://yourdomain.com
APP_ENV=production
```

2. Assurez-vous que le domaine pointe vers votre serveur :
   - DNS A record pointant vers l'IP du serveur
   - Ports 80 et 443 ouverts dans le firewall

3. Démarrez les services :
```bash
docker-compose up -d
```

4. Le certificat SSL sera généré automatiquement (peut prendre quelques minutes)

5. Accédez à : `https://yourdomain.com`

## Vérification

### Vérifier les certificats
```bash
docker-compose exec letsencrypt ls -la /etc/nginx/certs
```

### Vérifier les logs
```bash
docker-compose logs nginx-proxy
docker-compose logs letsencrypt
```

### Renouvellement automatique

Les certificats Let's Encrypt sont renouvelés automatiquement par le companion. Aucune action manuelle n'est nécessaire.

## Dépannage

### Le certificat ne se génère pas

1. Vérifiez que `LETSENCRYPT_HOST` correspond exactement au domaine
2. Vérifiez que le domaine pointe vers le serveur
3. Vérifiez les logs : `docker-compose logs letsencrypt`
4. Vérifiez que les ports 80 et 443 sont accessibles

### Erreur "Connection refused"

1. Vérifiez que tous les services sont démarrés : `docker-compose ps`
2. Vérifiez les logs : `docker-compose logs nginx-proxy`

### Forcer le renouvellement d'un certificat

```bash
docker-compose exec letsencrypt /app/force_renew yourdomain.com
```

