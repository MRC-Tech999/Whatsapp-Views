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
  
