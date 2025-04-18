<?php
$csv = file('contacts.csv', FILE_IGNORE_NEW_LINES);
$vcf = "";

foreach ($csv as $line) {
  list($name, $number) = explode(',', $line);
  $vcf .= "BEGIN:VCARD\nVERSION:3.0\nFN:$name\nTEL:$number\nEND:VCARD\n";
}

file_put_contents('contacts.vcf', $vcf);
echo "Fichier VCF généré avec succès.";
?>
