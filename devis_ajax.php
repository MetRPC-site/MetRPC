<?php
// Configuration email pour OVH
$to = "metrpc.pro@outlook.fr";  // Votre email de réception
$from = "contact@metrpc.fr";    // Email OVH lié à l'hébergement

// Headers pour AJAX
header('Content-Type: application/json');

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
            echo json_encode([
                'status' => 'error',
                'message' => 'Erreur lors de l\'envoi de l\'email. Veuillez réessayer ou nous contacter par téléphone au 06 78 44 23 48.'
            ]);
            error_log("Erreur envoi mail devis: " . print_r(error_get_last(), true));
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => "Demande envoyée avec succès ! Merci " . htmlspecialchars($nom) . " pour votre demande de devis. Nous vous contacterons rapidement."
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erreur dans le formulaire',
            'errors' => $errors
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Méthode non autorisée'
    ]);
}
?>