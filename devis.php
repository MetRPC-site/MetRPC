<?php
// Configuration email pour OVH
$to = "metrpc.pro@outlook.fr";  // Votre email de réception
$from = "contact@metrpc.fr";    // Email OVH lié à l'hébergement

// Vérifier si c'est une requête AJAX
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

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
        
        // Informations de l'email
        $JOUR = date("Y-m-d");
        $HEURE = date("H:i");
        
        $subject = "Nouvelle demande de devis METRPC - $JOUR $HEURE";
        
        // Contenu HTML de l'email
        $mail_Data = "";
        $mail_Data .= "<html>\n";
        $mail_Data .= "<head>\n";
        $mail_Data .= "<title>Demande de devis METRPC</title>\n";
        $mail_Data .= "<style>\n";
        $mail_Data .= "body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }\n";
        $mail_Data .= ".container { max-width: 600px; margin: 0 auto; padding: 20px; }\n";
        $mail_Data .= ".header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }\n";
        $mail_Data .= ".content { background: #f8f9fa; padding: 30px; border-radius: 0 0 8px 8px; }\n";
        $mail_Data .= ".field { margin-bottom: 20px; padding: 15px; background: white; border-radius: 5px; border-left: 4px solid #667eea; }\n";
        $mail_Data .= ".field-label { font-weight: bold; color: #667eea; margin-bottom: 5px; }\n";
        $mail_Data .= ".field-value { color: #333; }\n";
        $mail_Data .= ".footer { margin-top: 20px; padding: 15px; text-align: center; font-size: 12px; color: #666; }\n";
        $mail_Data .= "</style>\n";
        $mail_Data .= "</head>\n";
        $mail_Data .= "<body>\n";
        $mail_Data .= "<div class='container'>\n";
        $mail_Data .= "  <div class='header'>\n";
        $mail_Data .= "    <h1>📧 Nouvelle demande de devis</h1>\n";
        $mail_Data .= "    <p>METRPC - Réparation Informatique</p>\n";
        $mail_Data .= "  </div>\n";
        $mail_Data .= "  <div class='content'>\n";
        $mail_Data .= "    <p>Vous avez reçu une nouvelle demande de devis via votre site web :</p>\n";
        
        $mail_Data .= "    <div class='field'>\n";
        $mail_Data .= "      <div class='field-label'>👤 Nom complet :</div>\n";
        $mail_Data .= "      <div class='field-value'>" . htmlspecialchars($nom) . "</div>\n";
        $mail_Data .= "    </div>\n";
        
        $mail_Data .= "    <div class='field'>\n";
        $mail_Data .= "      <div class='field-label'>📧 Adresse email :</div>\n";
        $mail_Data .= "      <div class='field-value'>" . htmlspecialchars($email) . "</div>\n";
        $mail_Data .= "    </div>\n";
        
        $mail_Data .= "    <div class='field'>\n";
        $mail_Data .= "      <div class='field-label'>📞 Numéro de téléphone :</div>\n";
        $mail_Data .= "      <div class='field-value'>" . htmlspecialchars($telephone) . "</div>\n";
        $mail_Data .= "    </div>\n";
        
        $mail_Data .= "    <div class='field'>\n";
        $mail_Data .= "      <div class='field-label'>💻 Type d'appareil :</div>\n";
        $mail_Data .= "      <div class='field-value'>" . htmlspecialchars($typeAppareil) . "</div>\n";
        $mail_Data .= "    </div>\n";
        
        $mail_Data .= "    <div class='field'>\n";
        $mail_Data .= "      <div class='field-label'>🔧 Description du problème :</div>\n";
        $mail_Data .= "      <div class='field-value'>" . nl2br(htmlspecialchars($probleme)) . "</div>\n";
        $mail_Data .= "    </div>\n";
        
        $mail_Data .= "    <div class='footer'>\n";
        $mail_Data .= "      <p>📅 Demande reçue le : $JOUR à $HEURE</p>\n";
        $mail_Data .= "      <p>💡 Vous pouvez répondre directement à cet email pour contacter le client.</p>\n";
        $mail_Data .= "    </div>\n";
        $mail_Data .= "  </div>\n";
        $mail_Data .= "</div>\n";
        $mail_Data .= "</body>\n";
        $mail_Data .= "</html>\n";
        
        // Headers de l'email
        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=utf-8\n";
        $headers .= "From: $from\n";
        $headers .= "Reply-To: $email\n"; // Pour pouvoir répondre directement au client
        $headers .= "Disposition-Notification-To: $from\n";
        
        // Message de priorité haute
        $headers .= "X-Priority: 1\n";
        $headers .= "X-MSMail-Priority: High\n";
        
        // Tentative d'envoi
        $CR_Mail = @mail($to, $subject, $mail_Data, $headers);
        
        if ($CR_Mail === FALSE) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Erreur lors de l\'envoi de l\'email. Veuillez réessayer ou nous contacter par téléphone au 06 78 44 23 48.'
                ]);
            } else {
                $error_message = 'Erreur lors de l\'envoi de l\'email. Veuillez réessayer ou nous contacter par téléphone au 06 78 44 23 48.';
            }
            error_log("Erreur envoi mail devis: " . print_r(error_get_last(), true));
        } else {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => "Demande envoyée avec succès ! Merci " . htmlspecialchars($nom) . " pour votre demande de devis. Nous vous contacterons rapidement."
                ]);
            } else {
                $success = true;
            }
        }
    } else {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Erreur dans le formulaire',
                'errors' => $errors
            ]);
        } else {
            // $errors est déjà défini pour l'affichage HTML
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
    <script>
        // Rediriger vers la page principale après 3 secondes en cas de succès
        <?php if (isset($success) && $success): ?>
        setTimeout(function() {
            window.location.href = 'index.html#devis';
        }, 3000);
        <?php endif; ?>
    </script>
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
                <br><br>
                <small><i class="fas fa-info-circle"></i> Redirection automatique dans 3 secondes...</small>
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
                <?php echo htmlspecialchars($error_message); ?>
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