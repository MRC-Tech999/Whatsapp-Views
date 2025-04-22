// Importer les fonctions nécessaires de Firebase SDK
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-app.js";
import { getDatabase, ref, set, onValue, push } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-database.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-analytics.js";

// Configuration Firebase
const firebaseConfig = {
  apiKey: "AIzaSyB_oSRa9qh8CoV1rteVbyAqUr3dGrro9wY",
  authDomain: "whatsapp-views-52637.firebaseapp.com",
  databaseURL: "https://whatsapp-views-52637-default-rtdb.firebaseio.com",
  projectId: "whatsapp-views-52637",
  storageBucket: "whatsapp-views-52637.firebasestorage.app",
  messagingSenderId: "374291501495",
  appId: "1:374291501495:web:81fff180e4df890b489832",
  measurementId: "G-L2XNP3PPJ9"
};

// Initialiser Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const database = getDatabase(app);

// Met à jour le nombre de contacts en temps réel
function updateCount() {
  const countDisplay = document.getElementById('count');
  const contactsRef = ref(database, 'contacts');
  onValue(contactsRef, (snapshot) => {
    const contacts = snapshot.val();
    const count = contacts ? Object.keys(contacts).length : 0;
    countDisplay.textContent = "Nombre de contacts : " + count;
  });
}

// Ajouter un contact à Firebase
document.getElementById('contact-form').addEventListener('submit', function(e) {
  e.preventDefault();

  const name = document.getElementById('name').value.trim();
  const phone = document.getElementById('phone').value.trim();

  if (name && phone) {
    const contactsRef = ref(database, 'contacts');
    const newContactRef = push(contactsRef);
    set(newContactRef, {
      name: name,
      phone: phone
    });

    // Réinitialiser le formulaire
    document.getElementById('contact-form').reset();
    updateCount();
  } else {
    alert("Veuillez remplir tous les champs !");
  }
});

// Télécharger les contacts sous forme de fichier VCF
document.getElementById('download-btn').addEventListener('click', function() {
  const password = prompt("Entrez le mot de passe pour télécharger le fichier :");

  // Vérification du mot de passe
  if (password !== "2025") {
    alert("Mot de passe incorrect !");
    return;
  }

  const contactsRef = ref(database, 'contacts');
  onValue(contactsRef, (snapshot) => {
    const contacts = snapshot.val();
    if (!contacts) {
      alert("Aucun contact ajouté !");
      return;
    }

    let vcfContent = '';
    Object.values(contacts).forEach(contact => {
      vcfContent += `BEGIN:VCARD\nVERSION:3.0\nFN:${contact.name}\nTEL:${contact.phone}\nEND:VCARD\n`;
    });

    const blob = new Blob([vcfContent], { type: 'text/vcard' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'contacts.vcf';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  });
});

// Partager les contacts via WhatsApp
document.getElementById('whatsapp-btn').addEventListener('click', function() {
  const contactsRef = ref(database, 'contacts');
  onValue(contactsRef, (snapshot) => {
    const contacts = snapshot.val();
    if (!contacts) {
      alert("Ajoute au moins un contact d'abord !");
      return;
    }

    const message = encodeURIComponent("Voici mes contacts WhatsApp : \n\n" +
      Object.values(contacts).map(contact => `${contact.name}: ${contact.phone}`).join('\n'));

    const whatsappURL = `https://wa.me/?text=${message}`;
    window.open(whatsappURL, '_blank');
  });
});

// Appel de la fonction pour mettre à jour le compteur des contacts
updateCount();
  
