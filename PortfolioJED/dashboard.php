
<?php
include 'config.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Mon Espace</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<header><h1>Bienvenue <?php echo htmlspecialchars($user['name']); ?></h1></header>
<div class="container">
<p>Ceci est votre tableau de bord.</p>
<p><a href="project.php">Gérer mes projets</a> | <a href="skill.php">Gérer mes compétences</a> | <a href="logout.php">Déconnexion</a></p>
<?php if ($user['role'] == 'admin') { echo '<p><a href="admin.php">Interface administrateur</a></p>'; } ?>
</div>
</body></html>
