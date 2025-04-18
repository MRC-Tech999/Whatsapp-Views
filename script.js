(() => {
  const STORAGE_KEY = 'whatsapp_views_contacts';
  const PASSWORD = '2025';

  // Elements
  const form       = document.getElementById('form');
  const inputName  = document.getElementById('name');
  const inputNum   = document.getElementById('number');
  const msgEl      = document.getElementById('message');
  const counterEl  = document.getElementById('counter');
  const downloadBtn= document.getElementById('downloadBtn');

  // Charge les contacts depuis localStorage
  function loadContacts() {
    return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
  }

  // Sauvegarde
  function saveContacts(list) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(list));
  }

  // Met à jour le compteur
  function updateCounter() {
    const count = loadContacts().length;
    counterEl.textContent = 'Total inscrits : ' + count;
  }

  // Affiche un message
  function showMessage(text, type='success') {
    msgEl.textContent = text;
    msgEl.className = type;
    setTimeout(() => msgEl.className = 'hidden', 3000);
  }

  // Génère la string VCF
  function generateVCF(contacts) {
    let vcf = '';
    contacts.forEach(({name, number}) => {
      vcf += `BEGIN:VCARD\r\nVERSION:3.0\r\nFN:${name}\r\nTEL;TYPE=CELL:${number}\r\nEND:VCARD\r\n`;
    });
    return vcf;
  }

  // Téléchargement VCF
  downloadBtn.addEventListener('click', () => {
    const pwd = prompt('Entrez le code pour télécharger :');
    if (pwd !== PASSWORD) return showMessage('Code incorrect', 'error');
    const contacts = loadContacts();
    if (!contacts.length) return showMessage('Aucun contact à télécharger', 'error');
    const blob = new Blob([generateVCF(contacts)], {type: 'text/vcard'});
    const url  = URL.createObjectURL(blob);
    const a    = document.createElement('a');
    a.href     = url;
    a.download = 'contacts.vcf';
    a.click();
    URL.revokeObjectURL(url);
  });

  // Gestion du formulaire
  form.addEventListener('submit', e => {
    e.preventDefault();
    const name   = inputName.value.trim();
    const number = inputNum.value.trim();
    if (!name || !/^\+\d{6,15}$/.test(number)) {
      return showMessage('Nom ou numéro invalide', 'error');
    }
    let list = loadContacts();
    if (list.find(c => c.number === number)) {
      return showMessage('Numéro déjà enregistré', 'error');
    }
    list.push({name, number});
    saveContacts(list);
    inputName.value = '';
    inputNum.value  = '';
    showMessage('Contact enregistré !');
    updateCounter();
  });

  // Initialisation
  updateCounter();
})();
