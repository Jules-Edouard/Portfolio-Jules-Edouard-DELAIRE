
<?php
include 'config.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$message = '';
$user_id = $_SESSION['user']['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $link = $conn->real_escape_string($_POST['link']);
    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $target = 'uploads/' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image = $target;
        }
    }

    $sql = "INSERT INTO projects (user_id, title, description, image, link) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $title, $description, $image, $link);
    $stmt->execute();
    $message = "Projet ajouté.";
}

$projects = $conn->query("SELECT * FROM projects WHERE user_id = $user_id");
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Mes projets</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<header><h1>Gérer mes projets</h1></header>
<div class="container">
<?php if ($message) echo "<p>$message</p>"; ?>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Titre" required><br><br>
    <textarea name="description" placeholder="Description" required></textarea><br><br>
    <input type="url" name="link" placeholder="Lien externe"><br><br>
    <input type="file" name="image"><br><br>
    <input type="submit" value="Ajouter projet">
</form>
<h2>Mes projets</h2>
<ul>
<?php while ($row = $projects->fetch_assoc()) {
    echo "<li><strong>" . htmlspecialchars($row['title']) . "</strong> - " . htmlspecialchars($row['description']) . " <a href='" . htmlspecialchars($row['link']) . "' target='_blank'>Lien</a></li>";
} ?>
</ul>
<p><a href="dashboard.php">Retour au tableau de bord</a></p>
</div>
</body></html>
