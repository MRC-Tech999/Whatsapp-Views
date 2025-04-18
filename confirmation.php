<?php
$name   = trim($_POST['name']   ?? '');
$number = trim($_POST['number'] ?? '');
if ($name === '' || $number === '' || !preg_match('/^\+\d{6,15}$/', $number)) {
  header('Location: submit.html');
  exit;
}

// Fichiers de stockage
$csvFile = __DIR__ . '/contacts.csv';
$vcfFile = __DIR__ . '/contact.vcf';

// Crée contacts.csv s’il n’existe pas
if (!file_exists($csvFile)) {
  file_put_contents($csvFile, "name,number\n");
}

// Charge et vérifie doublon
$lines = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
  list(, $existing) = explode(',', $line);
  if ($existing === $number) {
    header('Location: submit.html');
    exit;
  }
}

// Ajoute au CSV
file_put_contents($csvFile, "$name,$number\n", FILE_APPEND);

// Regénère le VCF
include __DIR__ . '/generate_vcf.php';

// Compteur
$count = count(file($csvFile)) - 1; // on enlève la ligne d’en‑tête
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Succès – Whatsapp Views</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Enregistré avec succès !</h1>
    <p>Bienvenue, <strong><?= htmlspecialchars($name) ?></strong></p>
    <p>Vous êtes le <strong>#<?= $count ?></strong> de notre liste.</p>
    <a href="contact.vcf.php" class="btn">Télécharger le VCF</a>
    <a href="index.html" class="btn">Accueil</a>
  </div>
  <a href="#" class="top-link">⇪ Retour en haut</a>
</body>
</html>
