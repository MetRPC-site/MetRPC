# Configuration PHPMailer pour METRPC

## 📋 Instructions de configuration

### 1. Installation de PHPMailer

**Option A : Via Composer (recommandé)**
```bash
composer require phpmailer/phpmailer
```

**Option B : Téléchargement manuel**
1. Téléchargez PHPMailer depuis : https://github.com/PHPMailer/PHPMailer
2. Décompressez dans un dossier `PHPMailer/` à la racine de votre site
3. Modifiez les lignes dans `devis.php` :
   ```php
   require_once 'PHPMailer/src/PHPMailer.php';
   require_once 'PHPMailer/src/SMTP.php';
   require_once 'PHPMailer/src/Exception.php';
   ```

### 2. Configuration Gmail

**Étape 1 : Créer un mot de passe d'application**
1. Allez sur votre compte Google : https://myaccount.google.com/
2. Sécurité → Validation en deux étapes (activez-la si ce n'est pas fait)
3. Sécurité → Mots de passe des applications
4. Sélectionnez "Autre" et tapez "METRPC Website"
5. Copiez le mot de passe généré (16 caractères)

**Étape 2 : Modifier devis.php**
Remplacez dans le fichier `devis.php` :
```php
'smtp_username' => 'votre.email@gmail.com', // VOTRE EMAIL GMAIL
'smtp_password' => 'votre_mot_de_passe_app', // LE MOT DE PASSE D'APPLICATION
'from_email' => 'votre.email@gmail.com', // VOTRE EMAIL GMAIL
```

### 3. Test de la configuration

1. Uploadez tous les fichiers sur votre serveur OVH
2. Testez le formulaire depuis votre site
3. Vérifiez que vous recevez l'email sur metrpc.pro@outlook.fr

### 4. Structure des fichiers sur OVH

```
votre-site/
├── index.html
├── devis.php
├── css/
├── javascript/
├── images/
└── vendor/ (si Composer)
    └── phpmailer/
```

### 5. Paramètres Gmail

- **Serveur SMTP** : smtp.gmail.com
- **Port** : 587
- **Sécurité** : TLS
- **Authentification** : Oui

### 6. Dépannage

**Si les emails n'arrivent pas :**
1. Vérifiez les logs d'erreur PHP de votre hébergeur
2. Vérifiez le dossier spam de metrpc.pro@outlook.fr
3. Testez avec un autre email de réception
4. Contactez le support OVH si problème de serveur SMTP

**Erreurs courantes :**
- "SMTP Error: Could not authenticate" → Vérifiez le mot de passe d'application
- "SMTP connect() failed" → Vérifiez que le port 587 est ouvert chez OVH

### 7. Alternative : SMTP OVH

Si Gmail ne fonctionne pas, utilisez le SMTP d'OVH :
```php
'smtp_host' => 'ssl0.ovh.net', // ou smtp.votre-domaine.com
'smtp_port' => 587,
'smtp_username' => 'votre-email@votre-domaine.com',
'smtp_password' => 'votre-mot-de-passe-email',
```

---

## 🔧 Fichiers à modifier

### devis.php (déjà créé)
- Remplacez les informations fictives par vos vraies données
- Ligne 4-13 : Configuration email

### Aucune modification nécessaire sur :
- index.html (formulaire déjà configuré)
- CSS/JS existants

---

## 📧 Format de l'email reçu

Vous recevrez un email formaté avec :
- Nom du client
- Email du client (vous pourrez répondre directement)
- Téléphone
- Type d'appareil
- Description du problème
- Date/heure de la demande

L'email sera professionnel avec le style de votre site.