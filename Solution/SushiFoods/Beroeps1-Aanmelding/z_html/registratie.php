<?php
require "requires/config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm-password']);

    // Controleer of wachtwoorden overeenkomen
    if ($password !== $confirm_password) {
        header("Location: registreer.html?error=password_mismatch");
        exit;
    }

    // Hash het wachtwoord
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Controleer of de gebruikersnaam al bestaat
    $query = $con->query("SELECT * FROM users WHERE username = '".$con->real_escape_string($username)."'");
    if ($query->num_rows > 0) {
        header("Location: registreer.html?error=username_exists");
        exit;
    }
    // Voeg de gebruiker toe aan de database
$insert_query = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $con->prepare($insert_query);
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    // Gebruiker succesvol geregistreerd, doorverwijzen naar de inlogpagina
    header("Location: login.html?success=registration");
    exit;
} else {
    // Er is een fout opgetreden tijdens het registreren van de gebruiker
    header("Location: registreer.html?error=registration_error");
    exit;
}

$stmt->close();

}
?>
