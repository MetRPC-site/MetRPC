// Modern JavaScript for METRPC website

// Initialize AOS (Animate on Scroll) library
document.addEventListener('DOMContentLoaded', function() {
  AOS.init({
    duration: 800,
    offset: 100,
    once: true,
    easing: 'ease-out-cubic'
  });
});

// Enhanced Menu burger functionality
const menuBtn = document.querySelector('.menu-btn');
const navMenu = document.querySelector('.nav-menu');

if (menuBtn && navMenu) {
  // Function to close menu
  const closeMenu = () => {
    navMenu.classList.remove('active');
    menuBtn.classList.remove('active');
    document.body.style.overflow = '';
  };

  // Toggle menu
  menuBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    navMenu.classList.toggle('active');
    menuBtn.classList.toggle('active');
    
    // Prevent body scroll when menu is open on mobile
    if (navMenu.classList.contains('active')) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
  });

  // Close menu when clicking on navigation links
  document.querySelectorAll('.nav-menu a').forEach(link => {
    link.addEventListener('click', (e) => {
      if (link.getAttribute('href').startsWith('#')) {
        e.preventDefault();
        closeMenu();
        
        // Smooth scroll to section
        const targetId = link.getAttribute('href').substring(1);
        const targetSection = document.getElementById(targetId);
        
        if (targetSection) {
          setTimeout(() => {
            targetSection.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }, 300);
        }
      } else {
        closeMenu();
      }
    });
  });

  // Close menu when clicking outside
  document.addEventListener('click', (e) => {
    if (!menuBtn.contains(e.target) && !navMenu.contains(e.target)) {
      closeMenu();
    }
  });

  // Close menu on window resize
  window.addEventListener('resize', () => {
    if (window.innerWidth > 900) {
      closeMenu();
    }
  });
}

// Scroll to top button
const scrollToTopBtn = document.getElementById('scrollToTop');

if (scrollToTopBtn) {
  // Show/hide scroll to top button
  window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
      scrollToTopBtn.classList.add('visible');
    } else {
      scrollToTopBtn.classList.remove('visible');
    }
  });

  // Scroll to top functionality
  scrollToTopBtn.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

// Enhanced form handling with validation
const quoteForm = document.querySelector('.quote-form');
console.log('🔍 Formulaire trouvé:', quoteForm);

if (quoteForm) {
  const inputs = quoteForm.querySelectorAll('input, select, textarea');
  console.log('📝 Inputs trouvés:', inputs.length);
  
  // Add floating label effect
  inputs.forEach(input => {
    // Set initial state
    if (input.value) {
      input.classList.add('has-value');
    }

    // Handle focus and blur
    input.addEventListener('focus', () => {
      input.parentElement.classList.add('focused');
    });

    input.addEventListener('blur', () => {
      input.parentElement.classList.remove('focused');
      if (input.value) {
        input.classList.add('has-value');
      } else {
        input.classList.remove('has-value');
      }
    });

    // Real-time validation
    input.addEventListener('input', () => {
      validateField(input);
    });
  });

  // Form submission with AJAX
  quoteForm.addEventListener('submit', function(e) {
    console.log('🚀 Soumission formulaire interceptée !');
    
    // Vérifier si on est en local (file://) ou sur serveur
    const isLocalFile = window.location.protocol === 'file:';
    
    if (isLocalFile) {
      console.log('📁 Mode local détecté - soumission classique');
      // En local, laisser la soumission classique pour tester
      return true;
    }
    
    e.preventDefault(); // Intercepter seulement sur serveur web
    console.log('🌐 Mode serveur détecté - AJAX activé');
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    console.log('✅ Prévention de la soumission normale réussie');
    
    // Validate all fields
    let isValid = true;
    inputs.forEach(input => {
      if (!validateField(input)) {
        isValid = false;
      }
    });

    if (!isValid) {
      console.log('❌ Validation échouée');
      showNotification('Veuillez corriger les erreurs dans le formulaire.', 'error');
      return;
    }

    console.log('✅ Validation réussie, envoi AJAX...');

    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';
    submitBtn.disabled = true;

    // Prepare form data
    const formData = new FormData(this);

    // Send via AJAX to devis.php
    console.log('📡 Envoi AJAX vers devis.php...');
    fetch('devis.php', {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => {
      console.log('📥 Réponse reçue:', response.status);
      if (!response.ok) {
        throw new Error('Erreur réseau');
      }
      return response.json();
    })
    .then(data => {
      console.log('📊 Données JSON reçues:', data);
      if (data.status === 'success') {
        console.log('🎉 Succès, affichage notification');
        showNotification(data.message, 'success');
        this.reset();
        inputs.forEach(input => {
          input.classList.remove('has-value');
          input.parentElement.classList.remove('error');
        });
      } else {
        console.log('⚠️ Erreur dans la réponse');
        showNotification(data.message, 'error');
      }
    })
    .catch(error => {
      console.error('💥 Erreur AJAX:', error);
      // Fallback: essayer avec l'ancienne méthode (réponse HTML)
      console.log('🔄 Essai fallback...');
      fetch('devis.php', {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.text())
      .then(data => {
        console.log('📄 Réponse HTML fallback reçue');
        if (data.includes('success') || data.includes('envoyée avec succès')) {
          console.log('✅ Succès détecté dans HTML');
          showNotification('Votre demande de devis a été envoyée avec succès !', 'success');
          this.reset();
          inputs.forEach(input => {
            input.classList.remove('has-value');
            input.parentElement.classList.remove('error');
          });
        } else {
          console.log('❌ Échec détecté dans HTML');
          showNotification('Une erreur est survenue lors de l\'envoi. Veuillez réessayer ou nous contacter par téléphone au 06 78 44 23 48.', 'error');
        }
      })
      .catch(fallbackError => {
        console.error('💥 Erreur fallback:', fallbackError);
        showNotification('Une erreur est survenue lors de l\'envoi. Veuillez réessayer ou nous contacter par téléphone au 06 78 44 23 48.', 'error');
      });
    })
    .finally(() => {
      console.log('🔄 Remise à zéro du bouton');
      // Reset button state
      submitBtn.innerHTML = originalText;
      submitBtn.disabled = false;
    });
  });
} else {
  console.error('❌ Formulaire .quote-form non trouvé !');
}

// Field validation function
function validateField(field) {
  const value = field.value.trim();
  const fieldType = field.type;
  const fieldName = field.name;
  const fieldGroup = field.parentElement;
  
  // Remove existing error
  fieldGroup.classList.remove('error');
  let existingError = fieldGroup.querySelector('.error-message');
  if (existingError) {
    existingError.remove();
  }

  let isValid = true;
  let errorMessage = '';

  // Required field validation
  if (field.required && !value) {
    isValid = false;
    errorMessage = 'Ce champ est obligatoire.';
  }
  // Email validation
  else if (fieldType === 'email' && value && !isValidEmail(value)) {
    isValid = false;
    errorMessage = 'Veuillez saisir une adresse email valide.';
  }
  // Phone validation
  else if (fieldType === 'tel' && value && !isValidPhone(value)) {
    isValid = false;
    errorMessage = 'Veuillez saisir un numéro de téléphone valide.';
  }
  // Textarea minimum length
  else if (field.tagName === 'TEXTAREA' && value && value.length < 10) {
    isValid = false;
    errorMessage = 'Veuillez décrire plus précisément votre problème (minimum 10 caractères).';
  }

  if (!isValid) {
    fieldGroup.classList.add('error');
    const errorEl = document.createElement('span');
    errorEl.className = 'error-message';
    errorEl.textContent = errorMessage;
    fieldGroup.appendChild(errorEl);
  }

  return isValid;
}

// Helper functions for validation
function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

function isValidPhone(phone) {
  const phoneRegex = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/;
  return phoneRegex.test(phone.replace(/\s/g, ''));
}

// Notification system
function showNotification(message, type = 'info') {
  // Remove existing notifications
  const existingNotification = document.querySelector('.notification');
  if (existingNotification) {
    existingNotification.remove();
  }

  const notification = document.createElement('div');
  notification.className = `notification notification-${type}`;
  notification.innerHTML = `
    <div class="notification-content">
      <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
      <span>${message}</span>
    </div>
    <button class="notification-close">
      <i class="fas fa-times"></i>
    </button>
  `;

  document.body.appendChild(notification);

  // Add styles
  const style = document.createElement('style');
  style.textContent = `
    .notification {
      position: fixed;
      top: 100px;
      right: 20px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.15);
      z-index: 10000;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem 1.5rem;
      max-width: 400px;
      transform: translateX(100%);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border-left: 4px solid;
    }
    .notification.notification-success {
      border-left-color: #00D4AA;
    }
    .notification.notification-error {
      border-left-color: #FF6B35;
    }
    .notification.show {
      transform: translateX(0);
    }
    .notification-content {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .notification-content i {
      font-size: 1.2rem;
    }
    .notification-success .notification-content i {
      color: #00D4AA;
    }
    .notification-error .notification-content i {
      color: #FF6B35;
    }
    .notification-close {
      background: none;
      border: none;
      cursor: pointer;
      padding: 0.25rem;
      color: #999;
      transition: color 0.2s;
    }
    .notification-close:hover {
      color: #666;
    }
  `;
  document.head.appendChild(style);

  // Show notification
  setTimeout(() => notification.classList.add('show'), 100);

  // Auto-hide notification
  setTimeout(() => {
    notification.classList.remove('show');
    setTimeout(() => notification.remove(), 300);
  }, 5000);

  // Close button functionality
  notification.querySelector('.notification-close').addEventListener('click', () => {
    notification.classList.remove('show');
    setTimeout(() => notification.remove(), 300);
  });
}

// Smooth scrolling for all anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const targetId = this.getAttribute('href').substring(1);
    const targetElement = document.getElementById(targetId);
    
    if (targetElement) {
      const offsetTop = targetElement.offsetTop - 80; // Account for fixed header
      
      window.scrollTo({
        top: offsetTop,
        behavior: 'smooth'
      });
    }
  });
});

// Stats counter animation
const statsSection = document.querySelector('.stats-section');
if (statsSection) {
  const animateStats = () => {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    statNumbers.forEach(stat => {
      const targetValue = stat.textContent;
      const numericValue = parseInt(targetValue.replace(/\D/g, ''));
      
      if (numericValue && !stat.hasAttribute('data-animated')) {
        stat.setAttribute('data-animated', 'true');
        animateNumber(stat, 0, numericValue, targetValue, 2000);
      }
    });
  };

  // Intersection Observer for stats animation
  const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateStats();
        statsObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  statsObserver.observe(statsSection);
}

function animateNumber(element, start, end, originalText, duration) {
  const range = end - start;
  const increment = range / (duration / 16);
  let current = start;
  
  const timer = setInterval(() => {
    current += increment;
    if (current >= end) {
      current = end;
      clearInterval(timer);
    }
    
    // Format the number based on original text
    if (originalText.includes('+')) {
      element.textContent = Math.floor(current) + '+';
    } else if (originalText.includes('/5')) {
      element.textContent = (current / 100).toFixed(1) + '/5';
    } else if (originalText.includes('h')) {
      element.textContent = Math.floor(current) + 'h';
    } else {
      element.textContent = Math.floor(current);
    }
  }, 16);
}

// Enhanced button hover effects
document.querySelectorAll('.btn').forEach(button => {
  button.addEventListener('mouseenter', function() {
    this.style.transform = 'translateY(-2px)';
  });
  
  button.addEventListener('mouseleave', function() {
    this.style.transform = 'translateY(0)';
  });
});

// Form field error styling
const formErrorStyle = document.createElement('style');
formErrorStyle.textContent = `
  .form-group.error input,
  .form-group.error select,
  .form-group.error textarea {
    border-color: #FF6B35;
    box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
  }
  
  .error-message {
    color: #FF6B35;
    font-size: 0.8rem;
    margin-top: 0.25rem;
    display: block;
  }
  
  .form-group.focused label {
    color: var(--primary-color);
  }
`;
document.head.appendChild(formErrorStyle);

// Handle URL parameters for form success/error messages
const urlParams = new URLSearchParams(window.location.search);
const status = urlParams.get('status');

if (status === 'success') {
  showNotification('Votre demande de devis a bien été envoyée ! Nous vous contacterons rapidement.', 'success');
  // Clean URL
  window.history.replaceState({}, document.title, window.location.pathname);
} else if (status === 'error') {
  showNotification('Une erreur est survenue lors de l\'envoi de votre demande. Veuillez réessayer ou nous contacter directement par téléphone.', 'error');
  window.history.replaceState({}, document.title, window.location.pathname);
}

console.log('🚀 METRPC Website loaded successfully!');