<?php
// Configuration email - REMPLACEZ PAR VOS VRAIES INFORMATIONS
$config = [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_auth' => true,
    'smtp_username' => 'votre.email@gmail.com', // REMPLACEZ par votre email Gmail
    'smtp_password' => 'votre_mot_de_passe_app', // REMPLACEZ par votre mot de passe d'application Gmail
    'smtp_secure' => 'tls',
    'smtp_port' => 587,
    'from_email' => 'votre.email@gmail.com', // REMPLACEZ par votre email Gmail
    'from_name' => 'METRPC - Formulaire de Devis',
    'to_email' => 'metrpc.pro@outlook.fr', // Votre email où recevoir les demandes
    'to_name' => 'METRPC'
];

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Récupérer et nettoyer les données du formulaire
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
    $typeAppareil = isset($_POST['typeAppareil']) ? trim($_POST['typeAppareil']) : '';
    $probleme = isset($_POST['probleme']) ? trim($_POST['probleme']) : '';
    
    // Validation basique
    $errors = [];
    
    if (empty($nom)) {
        $errors[] = "Le nom est obligatoire";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Une adresse email valide est obligatoire";
    }
    
    if (empty($telephone)) {
        $errors[] = "Le numéro de téléphone est obligatoire";
    }
    
    if (empty($typeAppareil)) {
        $errors[] = "Le type d'appareil est obligatoire";
    }
    
    if (empty($probleme)) {
        $errors[] = "La description du problème est obligatoire";
    }
    
    // Si pas d'erreurs, envoyer l'email
    if (empty($errors)) {
        
        // Inclure PHPMailer (vous devrez télécharger PHPMailer)
        // Pour télécharger PHPMailer : https://github.com/PHPMailer/PHPMailer
        require_once 'vendor/autoload.php'; // Si installé via Composer
        // OU
        // require_once 'PHPMailer/src/PHPMailer.php';
        // require_once 'PHPMailer/src/SMTP.php';
        // require_once 'PHPMailer/src/Exception.php';
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        
        $mail = new PHPMailer(true);
        
        try {
            // Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host = $config['smtp_host'];
            $mail->SMTPAuth = $config['smtp_auth'];
            $mail->Username = $config['smtp_username'];
            $mail->Password = $config['smtp_password'];
            $mail->SMTPSecure = $config['smtp_secure'];
            $mail->Port = $config['smtp_port'];
            
            // Configuration de l'email
            $mail->setFrom($config['from_email'], $config['from_name']);
            $mail->addAddress($config['to_email'], $config['to_name']);
            $mail->addReplyTo($email, $nom); // Pour pouvoir répondre directement au client
            
            // Contenu de l'email
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Nouvelle demande de devis - METRPC';
            
            // Corps de l'email en HTML
            $mailBody = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                    .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 8px 8px; }
                    .field { margin-bottom: 20px; padding: 15px; background: white; border-radius: 5px; border-left: 4px solid #667eea; }
                    .field-label { font-weight: bold; color: #667eea; margin-bottom: 5px; }
                    .field-value { color: #333; }
                    .footer { margin-top: 20px; padding: 15px; text-align: center; font-size: 12px; color: #666; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>📧 Nouvelle demande de devis</h1>
                        <p>METRPC - Réparation Informatique</p>
                    </div>
                    <div class='content'>
                        <p>Vous avez reçu une nouvelle demande de devis via votre site web :</p>
                        
                        <div class='field'>
                            <div class='field-label'>👤 Nom complet :</div>
                            <div class='field-value'>" . htmlspecialchars($nom) . "</div>
                        </div>
                        
                        <div class='field'>
                            <div class='field-label'>📧 Adresse email :</div>
                            <div class='field-value'>" . htmlspecialchars($email) . "</div>
                        </div>
                        
                        <div class='field'>
                            <div class='field-label'>📞 Numéro de téléphone :</div>
                            <div class='field-value'>" . htmlspecialchars($telephone) . "</div>
                        </div>
                        
                        <div class='field'>
                            <div class='field-label'>💻 Type d'appareil :</div>
                            <div class='field-value'>" . htmlspecialchars($typeAppareil) . "</div>
                        </div>
                        
                        <div class='field'>
                            <div class='field-label'>🔧 Description du problème :</div>
                            <div class='field-value'>" . nl2br(htmlspecialchars($probleme)) . "</div>
                        </div>
                        
                        <div class='footer'>
                            <p>📅 Demande reçue le : " . date('d/m/Y à H:i:s') . "</p>
                            <p>💡 Vous pouvez répondre directement à cet email pour contacter le client.</p>
                        </div>
                    </div>
                </div>
            </body>
            </html>";
            
            $mail->Body = $mailBody;
            
            // Version texte alternative
            $mail->AltBody = "
Nouvelle demande de devis - METRPC

Nom: $nom
Email: $email
Téléphone: $telephone
Type d'appareil: $typeAppareil
Problème: $probleme

Demande reçue le: " . date('d/m/Y à H:i:s');
            
            // Envoyer l'email
            $mail->send();
            
            // Redirection vers une page de succès ou message de confirmation
            $success = true;
            
        } catch (Exception $e) {
            $error_message = "Erreur lors de l'envoi de l'email: " . $mail->ErrorInfo;
            error_log($error_message); // Log l'erreur
        }
        
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRPC - Demande de devis</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .message-container {
            max-width: 800px;
            margin: 100px auto;
            padding: 40px;
            text-align: center;
        }
        .success-message {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(76, 175, 80, 0.3);
            margin-bottom: 30px;
        }
        .error-message {
            background: linear-gradient(135deg, #f44336, #da190b);
            color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(244, 67, 54, 0.3);
            margin-bottom: 30px;
        }
        .message-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
        .message-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .message-text {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .back-button {
            display: inline-block;
            background: white;
            color: #667eea;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .error-list {
            text-align: left;
            margin: 20px 0;
        }
        .error-list li {
            margin-bottom: 10px;
            padding-left: 10px;
        }
    </style>
</head>
<body>

<div class="message-container">
    <?php if (isset($success) && $success): ?>
        
        <!-- Message de succès -->
        <div class="success-message">
            <div class="message-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="message-title">Demande envoyée avec succès !</div>
            <div class="message-text">
                Merci <strong><?php echo htmlspecialchars($nom); ?></strong> pour votre demande de devis.<br>
                Nous avons bien reçu votre demande concernant votre <strong><?php echo htmlspecialchars($typeAppareil); ?></strong>.<br><br>
                Nous vous contacterons dans les plus brefs délais à l'adresse <strong><?php echo htmlspecialchars($email); ?></strong> 
                ou au <strong><?php echo htmlspecialchars($telephone); ?></strong> pour établir votre devis personnalisé.
            </div>
            <a href="index.html" class="back-button">
                <i class="fas fa-home"></i> Retour à l'accueil
            </a>
        </div>
        
    <?php elseif (!empty($errors)): ?>
        
        <!-- Message d'erreur de validation -->
        <div class="error-message">
            <div class="message-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="message-title">Erreur dans le formulaire</div>
            <div class="message-text">
                Veuillez corriger les erreurs suivantes :
                <ul class="error-list">
                    <?php foreach ($errors as $error): ?>
                        <li><i class="fas fa-times"></i> <?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a href="javascript:history.back()" class="back-button">
                <i class="fas fa-arrow-left"></i> Retour au formulaire
            </a>
        </div>
        
    <?php elseif (isset($error_message)): ?>
        
        <!-- Message d'erreur technique -->
        <div class="error-message">
            <div class="message-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="message-title">Erreur technique</div>
            <div class="message-text">
                Une erreur s'est produite lors de l'envoi de votre demande.<br>
                Veuillez réessayer ou nous contacter directement par téléphone au <strong>06 78 44 23 48</strong>.
            </div>
            <a href="javascript:history.back()" class="back-button">
                <i class="fas fa-redo"></i> Réessayer
            </a>
        </div>
        
    <?php else: ?>
        
        <!-- Accès direct sans soumission -->
        <div class="error-message">
            <div class="message-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="message-title">Accès non autorisé</div>
            <div class="message-text">
                Cette page est destinée au traitement des demandes de devis.<br>
                Veuillez utiliser le formulaire sur notre page d'accueil.
            </div>
            <a href="index.html#devis" class="back-button">
                <i class="fas fa-edit"></i> Faire une demande de devis
            </a>
        </div>
        
    <?php endif; ?>
</div>

</body>
</html>