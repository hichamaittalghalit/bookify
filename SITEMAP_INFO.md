# Sitemap pour Google Search Console

## URL du Sitemap

Votre sitemap est disponible à l'adresse suivante :
```
https://bookz.today/sitemap.xml
```

## Comment l'ajouter dans Google Search Console

1. Connectez-vous à [Google Search Console](https://search.google.com/search-console)
2. Sélectionnez votre propriété (bookz.today)
3. Allez dans **Sitemaps** dans le menu de gauche
4. Entrez l'URL : `sitemap.xml`
5. Cliquez sur **Envoyer**

## Liens inclus dans le sitemap

Le sitemap génère automatiquement les URLs suivantes :

### Page d'accueil
- **URL** : `https://bookz.today/`
- **Priorité** : 1.0
- **Fréquence** : Daily

### Livres actifs
- **Format** : `https://bookz.today/books/{slug}`
- **Priorité** : 0.8
- **Fréquence** : Weekly
- **Exemple** : `https://bookz.today/books/mon-livre`

### Pages statiques
- **Contact** : `https://bookz.today/contact` (Priorité: 0.7)
- **FAQ** : `https://bookz.today/faq` (Priorité: 0.6)
- **Mentions légales** : `https://bookz.today/legal-notice` (Priorité: 0.5)
- **Conditions d'utilisation** : `https://bookz.today/terms` (Priorité: 0.5)
- **Politique de confidentialité** : `https://bookz.today/privacy` (Priorité: 0.5)

## Robots.txt

Le fichier `robots.txt` est configuré et pointe vers le sitemap :
```
User-agent: *
Allow: /

Sitemap: https://bookz.today/sitemap.xml
```

## Vérification

Pour vérifier que le sitemap fonctionne :
1. Visitez : `https://bookz.today/sitemap.xml`
2. Vous devriez voir un fichier XML avec toutes les URLs
3. Le sitemap se met à jour automatiquement quand vous ajoutez/modifiez des livres

## Notes importantes

- Seuls les livres **actifs** (`is_active = true`) sont inclus dans le sitemap
- Les livres inactifs ne sont pas indexés
- Le sitemap est généré dynamiquement à chaque requête
- Les dates de modification sont basées sur `updated_at` de chaque livre

