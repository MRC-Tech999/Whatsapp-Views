<?php
$host = "localhost";
$user = "root";
$pass = ""; // ton mot de passe
$db = "whatsapp_views";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connexion échouée");

header('Content-Type: text/vcard');
header('Content-Disposition: attachment; filename="contacts.vcf"');

$result = $conn->query("SELECT name, phone FROM contacts");

while ($row = $result->fetch_assoc()) {
  echo "BEGIN:VCARD\n";
  echo "VERSION:3.0\n";
  echo "FN:" . $row['name'] . "\n";
  echo "TEL:" . $row['phone'] . "\n";
  echo "END:VCARD\n\n";
}

$conn->close();
?>
