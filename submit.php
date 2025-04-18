<?php
// Traitement de l’enregistrement et affichage du formulaire + compteur

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name   = trim($_POST['name']   ?? '');
  $number = trim($_POST['number'] ?? '');

  // Validation simple du numéro
  if ($name !== '' && preg_match('/^\+\d{6,15}$/', $number)) {
    $csvFile = __DIR__ . '/contacts.csv';
    $vcfFile = __DIR__ . '/contact.vcf';

    // Créer CSV avec en‑tête
    if (!file_exists($csvFile)) {
      file_put_contents($csvFile, "name,number\n");
    }

    // Vérifier si déjà présent
    $lines = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $isNew = true;
    foreach ($lines as $idx => $line) {
      if ($idx === 0) continue;
      list(, $num) = explode(',', $line);
      if ($num === $number) {
        $isNew = false;
        break;
      }
    }

    // Ajouter si nouveau
    if ($isNew) {
      file_put_contents($csvFile, "$name,$number\n", FILE_APPEND);
      include __DIR__ . '/generate_vcf.php';
      $success = true;
    }
  }
}

// Compter les inscrits
$count = 0;
if (file_exists(__DIR__ . '/contacts.csv')) {
  $all = file(__DIR__ . '/contacts.csv', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  $count = max(0, count($all) - 1);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription – WhatsApp Views</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Inscrivez-vous</h1>

    <?php if ($success): ?>
      <div class="alert success">Contact enregistré avec succès !</div>
    <?php endif; ?>

    <form action="" method="POST" class="form">
      <input type="text"   name="name"   placeholder="Votre nom complet" required>
      <input type="text"   name="number" placeholder="+22512345678"      required>
      <button type="submit">Continuer</button>
    </form>

    <p class="counter">Total inscrits : <strong><?= $count ?></strong></p>

    <div class="social">
      <a href="https://instagram.com/j.m.h.2024" target="_blank">Instagram</a> |
      <a href="mailto:contactwhatsappviews@gmail.com">Email</a>
    </div>

    <a href="index.html" class="btn link-home">← Retour à l’accueil</a>
  </div>
</body>
</html>
