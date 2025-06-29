
<?php
include 'config.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$message = '';
$user_id = $_SESSION['user']['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $skill_id = intval($_POST['skill_id']);
    $level = $conn->real_escape_string($_POST['level']);
    $conn->query("REPLACE INTO user_skills (user_id, skill_id, level) VALUES ($user_id, $skill_id, '$level')");
    $message = "Compétence mise à jour.";
}

$skills = $conn->query("SELECT * FROM skills");
$user_skills = [];
$res = $conn->query("SELECT * FROM user_skills WHERE user_id = $user_id");
while ($row = $res->fetch_assoc()) {
    $user_skills[$row['skill_id']] = $row['level'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Mes compétences</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<header><h1>Gérer mes compétences</h1></header>
<div class="container">
<?php if ($message) echo "<p>$message</p>"; ?>
<form method="post">
    <select name="skill_id" required>
        <?php while ($row = $skills->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
        } ?>
    </select>
    <select name="level" required>
        <option value="débutant">Débutant</option>
        <option value="intermédiaire">Intermédiaire</option>
        <option value="avancé">Avancé</option>
        <option value="expert">Expert</option>
    </select>
    <input type="submit" value="Enregistrer">
</form>
<h2>Mes compétences</h2>
<ul>
<?php foreach ($user_skills as $skill_id => $level) {
    $skill_name = $conn->query("SELECT name FROM skills WHERE id = $skill_id")->fetch_assoc()['name'];
    echo "<li>" . htmlspecialchars($skill_name) . " - " . htmlspecialchars($level) . "</li>";
} ?>
</ul>
<p><a href="dashboard.php">Retour au tableau de bord</a></p>
</div>
</body></html>
