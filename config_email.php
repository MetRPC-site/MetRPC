<?php
// Configuration email sécurisée - NE PAS VERSIONNER CE FICHIER
// Ajoutez ce fichier dans .gitignore si vous utilisez Git

return [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_auth' => true,
    'smtp_username' => 'VOTRE_EMAIL@gmail.com', // REMPLACEZ par votre email Gmail
    'smtp_password' => 'VOTRE_MOT_DE_PASSE_APP', // REMPLACEZ par votre mot de passe d'application Gmail (16 caractères)
    'smtp_secure' => 'tls',
    'smtp_port' => 587,
    'from_email' => 'VOTRE_EMAIL@gmail.com', // REMPLACEZ par votre email Gmail
    'from_name' => 'METRPC - Formulaire de Devis',
    'to_email' => 'metrpc.pro@outlook.fr', // Votre email où recevoir les demandes
    'to_name' => 'METRPC'
];