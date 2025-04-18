<?php
// Lit contacts.csv et produit contact.vcf
$csv = __DIR__ . '/contacts.csv';
$vcf = __DIR__ . '/contact.vcf';
if (!file_exists($csv)) return;

$lines = file($csv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$vcards = "";
foreach ($lines as $i => $line) {
  if ($i === 0) continue; // skip header
  list($n, $num) = explode(',', $line);
  $vcards .= "BEGIN:VCARD\r\n";
  $vcards .= "VERSION:3.0\r\n";
  $vcards .= "FN:$n\r\n";
  $vcards .= "TEL;TYPE=CELL:$num\r\n";
  $vcards .= "END:VCARD\r\n";
}
file_put_contents($vcf, $vcards);
