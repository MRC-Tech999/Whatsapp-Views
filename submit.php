<?php
$host = "localhost";
$user = "root";
$pass = ""; // mets ton mot de passe MySQL si tu en as un
$db = "whatsapp_views";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Erreur de connexion : " . $conn->connect_error);

$name = trim($_POST['name']);
$phone = trim($_POST['phone']);

// Vérifie si déjà enregistré
$stmt = $conn->prepare("SELECT id FROM contacts WHERE phone = ?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  echo "<script>alert('Ce numéro est déjà inscrit !'); window.location='submit.html';</script>";
} else {
  $stmt = $conn->prepare("INSERT INTO contacts (name, phone) VALUES (?, ?)");
  $stmt->bind_param("ss", $name, $phone);
  if ($stmt->execute()) {
    echo "<script>alert('Numéro enregistré avec succès !'); window.location='index.html';</script>";
  } else {
    echo "Erreur : " . $conn->error;
  }
}

$conn->close();
?>
