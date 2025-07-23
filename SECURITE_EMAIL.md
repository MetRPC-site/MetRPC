# 🔐 Guide de Sécurisation des Identifiants Email

## ✅ Solutions mises en place

### 1. Fichier de configuration séparé
- **config_email.php** : Contient vos identifiants
- **devis.php** : Script principal (sans identifiants visibles)
- **.gitignore** : Protège le fichier de configuration

## 🛡️ Mesures de sécurité appliquées

### 1. Séparation des credentials
```
/votre-site/
├── devis.php (code public)
├── config_email.php (credentials privés)
└── .gitignore (protection Git)
```

### 2. Protection contre le versioning
Le fichier `.gitignore` empêche `config_email.php` d'être ajouté à Git accidentellement.

### 3. Protection serveur OVH
Ajoutez ce fichier `.htaccess` pour protéger votre config :

```apache
# Protection config_email.php
<Files "config_email.php">
    Order Allow,Deny
    Deny from all
</Files>

# Protection .gitignore
<Files ".gitignore">
    Order Allow,Deny
    Deny from all
</Files>
```

## 🔧 Configuration sécurisée

### Étape 1 : Configurez config_email.php
```php
'smtp_username' => 'votre.email@gmail.com',
'smtp_password' => 'abcd efgh ijkl mnop', // Mot de passe d'application (16 caractères)
```

### Étape 2 : Permissions fichiers (sur OVH)
```bash
chmod 600 config_email.php  # Lecture seule pour le propriétaire
chmod 644 devis.php         # Lecture pour tous, écriture propriétaire
```

### Étape 3 : Créez .htaccess (optionnel mais recommandé)

## 🚨 Bonnes pratiques

### ✅ À FAIRE :
- ✅ Utilisez des mots de passe d'application Gmail (16 caractères)
- ✅ Ne partagez jamais le fichier `config_email.php`
- ✅ Sauvegardez vos credentials dans un gestionnaire de mots de passe
- ✅ Changez régulièrement vos mots de passe d'application

### ❌ À NE PAS FAIRE :
- ❌ Ne commitez jamais `config_email.php` sur Git
- ❌ Ne mettez pas vos credentials dans le code principal
- ❌ N'utilisez pas votre mot de passe Gmail principal
- ❌ Ne laissez pas le fichier accessible via navigateur

## 🔍 Vérification de sécurité

### Test 1 : Accès navigateur
Essayez d'accéder à : `https://votre-site.com/config_email.php`
→ Doit être bloqué (erreur 403)

### Test 2 : Fonctionnalité
Le formulaire de devis doit toujours fonctionner normalement.

## 🆘 En cas de compromission

Si vous pensez que vos credentials sont compromis :

1. **Immédiatement :**
   - Révevoquez le mot de passe d'application Gmail
   - Créez un nouveau mot de passe d'application
   - Mettez à jour `config_email.php`

2. **Vérification :**
   - Consultez l'activité de votre compte Google
   - Vérifiez les emails envoyés depuis votre compte

## 📱 Alternative : Variables d'environnement

Pour une sécurité maximale, vous pouvez aussi utiliser les variables d'environnement du serveur :

```php
// Dans config_email.php
return [
    'smtp_username' => $_ENV['GMAIL_USERNAME'] ?? getenv('GMAIL_USERNAME'),
    'smtp_password' => $_ENV['GMAIL_PASSWORD'] ?? getenv('GMAIL_PASSWORD'),
    // ...
];
```

Puis définir sur votre serveur OVH (via cPanel ou .htaccess).

---

## 🎯 Résumé

Vos identifiants sont maintenant :
- ✅ **Séparés** du code principal
- ✅ **Protégés** contre le versioning Git  
- ✅ **Sécurisés** sur le serveur
- ✅ **Cachés** des visiteurs du site

Votre site reste fonctionnel mais vos credentials sont protégés !