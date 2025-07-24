// Test local pour simuler le succès de l'envoi

// Simuler une notification de succès après 2 secondes
setTimeout(() => {
  if (typeof showNotification === 'function') {
    showNotification('Test réussi ! Votre demande de devis a été envoyée avec succès !', 'success');
  }
}, 2000);

console.log('🧪 Test mode: Simulation notification de succès dans 2 secondes');