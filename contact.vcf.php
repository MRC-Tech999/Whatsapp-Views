<?php
header('Content-Type: text/vcard');
header('Content-Disposition: attachment; filename="contacts.vcf"');

$csvFile = 'contacts.csv';

if (!file_exists($csvFile)) {
    die("Aucun contact trouvé.");
}

$lines = file($csvFile, FILE_IGNORE_NEW_LINES);
foreach ($lines as $line) {
    list($name, $number) = explode(',', $line);
    echo "BEGIN:VCARD\n";
    echo "VERSION:3.0\n";
    echo "FN:" . htmlspecialchars($name) . "\n";
    echo "TEL:" . htmlspecialchars($number) . "\n";
    echo "END:VCARD\n";
}
?>
