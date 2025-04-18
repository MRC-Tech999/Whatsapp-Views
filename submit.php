<?php
// submit.php

// --- Traitement POST ---
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = trim($_POST['name']   ?? '');
    $number = trim($_POST['number'] ?? '');

    // Validation basique
    if ($name !== '' && preg_match('/^\+\d{6,15}$/', $number)) {
        $csvFile = __DIR__ . '/contacts.csv';
        $vcfFile = __DIR__ . '/contact.vcf';

        // Crée contacts.csv si nécessaire, avec en‑tête
        if (!file_exists($csvFile)) {
            file_put_contents($csvFile, "name,number\n");
        }

        // Lecture pour détection de doublon
        $lines = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $isNew = true;
        foreach ($lines as $i => $line) {
            if ($i === 0) continue; // on saute l'en‑tête
            list(, $num) = explode(',', $line);
            if ($num === $number) {
                $isNew = false;
                break;
            }
        }

        // Si nouveau, on ajoute et on régénère le VCF
        if ($isNew) {
            file_put_contents($csvFile, "$name,$number\n", FILE_APPEND);
            include __DIR__ . '/generate_vcf.php';
            $success = true;
        }
    }
}

// --- Calcul du compteur ---
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
  <title>Enregistrement – Whatsapp Views</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Enregistrez votre numéro</h1>

    <?php if ($success): ?>
      <p class="message-success">Contact enregistré avec succès !</p>
    <?php endif; ?>

    <form action="" method="POST">
      <input type="text" name="name" placeholder="Votre nom complet" required>
      <input type="text" name="number" placeholder="Ex : +22512345678" required>
      <button type="submit">Continuer</button>
    </form>

    <p class="compteur">Total inscrits : <?= $count ?></p>

    <div class="social">
      <a href="https://instagram.com/j.m.h.2024" class="social-btn" target="_blank">Instagram</a>
      <a href="mailto:contactwhatsappviews@gmail.com" class="social-btn">Email</a>
    </div>

    <footer>&copy; 2025 MRC‑Tech</footer>
  </div>
</body>
</html>
