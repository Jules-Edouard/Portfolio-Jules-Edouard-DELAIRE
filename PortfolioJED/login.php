
<?php
include 'config.php';
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Mot de passe incorrect.";
        }
    } else {
        $message = "Email non trouvé.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Connexion</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<header><h1>Connexion</h1></header>
<div class="container">
<?php if ($message) echo "<p>$message</p>"; ?>
<form method="post">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br><br>
    <input type="submit" value="Se connecter">
</form>
<a href="register.php">Créer un compte</a>
</div>
</body></html>
