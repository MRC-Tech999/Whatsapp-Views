let contacts = [];

document.getElementById('contact-form').addEventListener('submit', function(e) {
  e.preventDefault();
  const name = document.getElementById('name').value.trim();
  const phone = document.getElementById('phone').value.trim();

  if (name && phone) {
    contacts.push({ name, phone });
    document.getElementById('count').textContent = "Nombre de contacts : " + contacts.length;
    document.getElementById('contact-form').reset();
  }
});

document.getElementById('download-btn').addEventListener('click', function() {
  if (contacts.length === 0) {
    alert("Aucun contact ajouté !");
    return;
  }

  const password = prompt("Entrez le mot de passe pour télécharger le fichier :");
  if (password !== "2025") {
    alert("Mot de passe incorrect !");
    return;
  }

  let vcfContent = '';
  contacts.forEach(contact => {
    vcfContent += `BEGIN:VCARD\nVERSION:3.0\nFN:${contact.name}\nTEL:${contact.phone}\nEND:VCARD\n`;
  });

  const blob = new Blob([vcfContent], { type: 'text/vcard' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'contacts_2025.vcf';
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
});

document.getElementById('whatsapp-btn').addEventListener('click', function() {
  if (contacts.length === 0) {
    alert("Ajoute au moins un contact d'abord !");
    return;
  }

  const message = encodeURIComponent(
    "Voici les contacts à ajouter (générés avec l'outil 2025). Envoie-moi ton fichier .vcf si tu veux le recevoir."
  );

  const whatsappURL = `https://wa.me/?text=${message}`;
  window.open(whatsappURL, '_blank');
});
                   
