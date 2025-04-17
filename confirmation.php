<?php
$name = trim($_POST['name']);
$number = trim($_POST['number']);
$code = trim($_POST['code']);

if ($code !== "2025") {
  die("Code incorrect. Retournez et essayez de nouveau.");
}

$file = 'contacts.csv';
$alreadyAdded = false;

if (file_exists($file)) {
  $lines = file($file, FILE_IGNORE_NEW_LINES);
  foreach ($lines as $line) {
    list($existingName, $existingNumber) = explode(',', $line);
    if ($existingNumber == $number) {
      $alreadyAdded = true;
      break;
    }
  }
}

if (!$alreadyAdded) {
  file_put_contents($file, "$name,$number\n", FILE_APPEND);
  $id = count(file($file));
} else {
  die("Ce numéro est déjà inscrit !");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background: linear-gradient(135deg, #7209b7, #f72585);
      color: white;
      font-family: 'Segoe UI', sans-serif;
      text-align: center;
      padding: 40px;
    }
    .social-btn {
      background: white;
      color: #7209b7;
      padding: 12px 24px;
      margin: 10px;
      border-radius: 6px;
      font-weight: bold;
      text-decoration: none;
      display: inline-block;
    }
  </style>
</head>
<body>
  <h2>Merci <?= htmlspecialchars($name) ?> !</h2>
  <p>Vous êtes bien enregistré (ID #<?= $id ?>).</p>
  <a class="social-btn" href="contacts.vcf" download>Télécharger le fichier VCF</a>

  <div class="social">
    <a class="social-btn" href="https://instagram.com/j.m.h.2024" target="_blank">Instagram</a>
    <a class="social-btn" href="mailto:contactwhatsappviews@gmail.com">Email</a>
  </div>
</body>
</html>
