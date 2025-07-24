# 📧 Configuration Email pour OVH - METRPC

## ✅ Version Simplifiée - Fonction mail() PHP native

### 🎯 Avantages de cette version :
- ✅ **Pas de PHPMailer** nécessaire
- ✅ **Fonctionne directement** sur l'hébergement OVH
- ✅ **Configuration simple** 
- ✅ **Emails HTML professionnels**
- ✅ **Sécurisé** contre les injections

### 🔧 Configuration requise :

#### 1. Email OVH
```php
$to = "metrpc.pro@outlook.fr";  // Votre email de réception
$from = "contact@metrpc.fr";    // Email OVH lié à l'hébergement
```

**Important :** L'email `$from` doit être lié à votre hébergement OVH pour fonctionner.

#### 2. Fonctionnalités incluses :
- **Validation complète** des données du formulaire
- **Email HTML stylé** avec design professionnel
- **Reply-To** configuré pour répondre directement au client
- **Priorité haute** pour les demandes de devis
- **Gestion d'erreurs** complète
- **Messages de confirmation** stylés
- **Protection XSS** avec htmlspecialchars()

### 📝 Structure de l'email reçu :

Vous recevrez un email formaté contenant :
- 👤 **Nom complet** du client
- 📧 **Email** du client (reply-to automatique)
- 📞 **Téléphone** du client
- 💻 **Type d'appareil** concerné
- 🔧 **Description détaillée** du problème
- 📅 **Date et heure** de la demande

### 🚀 Déploiement sur OVH :

1. **Uploadez le fichier** `devis.php` sur votre serveur
2. **Vérifiez que l'email** `contact@metrpc.fr` existe dans votre cPanel OVH
3. **Testez le formulaire** depuis votre site
4. **Vérifiez la réception** sur metrpc.pro@outlook.fr

### 🛠️ Dépannage :

**Si les emails n'arrivent pas :**
1. Vérifiez que `contact@metrpc.fr` est créé dans cPanel OVH
2. Consultez les logs PHP de votre hébergeur
3. Vérifiez le dossier spam
4. Testez avec un autre email de réception

**Erreurs courantes :**
- Email FROM non lié à l'hébergement
- Fonction mail() désactivée (rare sur OVH)
- Filtres anti-spam trop stricts

### 📞 Support :
En cas de problème, contactez le support OVH ou votre développeur.

---

## 🔧 Code basé sur votre exemple fonctionnel

Cette implémentation utilise exactement la même logique que votre code de test qui fonctionne, adaptée pour le formulaire de devis.