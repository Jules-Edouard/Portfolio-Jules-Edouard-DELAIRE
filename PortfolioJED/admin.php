
<?php
include 'config.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: login.php");
    exit;
}
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $conn->query("INSERT INTO skills (name) VALUES ('$name')");
    $message = "Compétence ajoutée.";
}
$skills = $conn->query("SELECT * FROM skills");
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Admin</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<header><h1>Admin - Gérer les compétences</h1></header>
<div class="container">
<?php if ($message) echo "<p>$message</p>"; ?>
<form method="post">
    <input type="text" name="name" placeholder="Nom de la compétence" required>
    <input type="submit" value="Ajouter">
</form>
<h2>Compétences existantes</h2>
<ul>
<?php while ($row = $skills->fetch_assoc()) { echo "<li>" . htmlspecialchars($row['name']) . "</li>"; } ?>
</ul>
<p><a href="dashboard.php">Retour au tableau de bord</a></p>
</div>
</body></html>
