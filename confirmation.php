<?php
$name   = trim($_POST['name']   ?? '');
$number = trim($_POST['number'] ?? '');
// Validation basique
if ($name === '' || $number === '' || !preg_match('/^\+\d{6,15}$/', $number)) {
  header('Location: submit.html');
  exit;
}

$csvFile = __DIR__.'/contacts.csv';
$vcfFile = __DIR__.'/contact.vcf';

// Crée contacts.csv avec en-tête si nécessaire
if (!file_exists($csvFile)) {
  file_put_contents($csvFile, "name,number\n");
}

// Vérifie doublon
$lines = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $i => $line) {
  if ($i === 0) continue;
  list(, $num) = explode(',', $line);
  if ($num === $number) {
    header('Location: submit.html');
    exit;
  }
}

// Ajoute au CSV
file_put_contents($csvFile, "$name,$number\n", FILE_APPEND);

// Regénère le VCF
include __DIR__.'/generate_vcf.php';

// Retour à la page de formulaire avec le message de succès
header('Location: submit.html?success=1');
exit;
