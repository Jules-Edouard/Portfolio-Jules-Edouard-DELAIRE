
<?php
include 'config.php';
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user';

    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    if ($stmt->execute()) {
        $message = "Inscription réussie. Vous pouvez maintenant vous connecter.";
    } else {
        $message = "Erreur : " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Inscription</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<header><h1>Inscription</h1></header>
<div class="container">
<?php if ($message) echo "<p>$message</p>"; ?>
<form method="post">
    <input type="text" name="name" placeholder="Nom" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br><br>
    <input type="submit" value="S'inscrire">
</form>
<a href="login.php">Déjà un compte ? Connectez-vous</a>
</div>
</body></html>
