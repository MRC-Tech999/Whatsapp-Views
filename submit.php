<?php
$host = "localhost";
$user = "root";
$pass = ""; // à adapter si tu as un mot de passe
$db = "whatsapp_views";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Erreur de connexion : " . $conn->connect_error);
}

$name = trim($_POST['name']);
$phone = trim($_POST['phone']);

// Évite les doublons
$stmt = $conn->prepare("SELECT id FROM contacts WHERE phone = ?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  echo "Ce numéro est déjà enregistré.";
} else {
  $stmt = $conn->prepare("INSERT INTO contacts (name, phone) VALUES (?, ?)");
  $stmt->bind_param("ss", $name, $phone);
  if ($stmt->execute()) {
    echo "Numéro ajouté avec succès.";
  } else {
    echo "Erreur : " . $conn->error;
  }
}

$conn->close();
?>
