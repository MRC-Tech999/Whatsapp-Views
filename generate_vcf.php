<?php
// Demande le mot de passe avant de servir le VCF
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (($_POST['pwd'] ?? '') === '2025') {
    header('Content-Type: text/vcard');
    header('Content-Disposition: attachment; filename="contact.vcf"');
    readfile(__DIR__ . '/contact.vcf');
    exit;
  } else {
    $err = "Mot de passe incorrect.";
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Protection VCF</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Mot de passe requis</h1>
    <form method="POST">
      <input type="password" name="pwd" placeholder="Entrez le code" required>
      <button type="submit">Valider</button>
    </form>
    <?php if (!empty($err)): ?>
      <p class="error"><?= $err ?></p>
    <?php endif; ?>
    <a href="index.html" class="btn">Retour</a>
  </div>
  <a href="#" class="top-link">⇪ Retour en haut</a>
</body>
</html>
