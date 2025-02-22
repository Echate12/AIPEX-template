<?php
// process_verification.php

// Database connection details
$servername = "localhost";
$username   = "root";      // XAMPP default username
$password   = "";          // XAMPP default password is empty
$dbname     = "formulaire"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize the diploma number from POST
$numero_diplome = trim($_POST['numero_diplome']);

// Prepare the SQL statement to search for the diploma number
$sql = "SELECT * FROM formulaire WHERE numero_diplome = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $numero_diplome);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Résultat de Vérification</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <?php
    if ($result->num_rows > 0) {
      // Diploma found – display its details.
      $row = $result->fetch_assoc();
      echo '<div class="alert alert-success" role="alert">';
      echo '<h4 class="alert-heading">Diplôme trouvé !</h4>';
      echo '<p><strong>ID:</strong> ' . htmlspecialchars($row['id']) . '</p>';
      echo '<p><strong>Numero de Diplome:</strong> ' . htmlspecialchars($row['numero_diplome']) . '</p>';
      echo '<p><strong>Prenom:</strong> ' . htmlspecialchars($row['prenom']) . '</p>';
      echo '<p><strong>Nom:</strong> ' . htmlspecialchars($row['nom']) . '</p>';
      echo '<p><strong>Session (Année):</strong> ' . htmlspecialchars($row['session']) . '</p>';
      echo '<p><strong>Grade:</strong> ' . htmlspecialchars($row['grade']) . '</p>';
      echo '<p><strong>Mention:</strong> ' . htmlspecialchars($row['mention']) . '</p>';
      echo '</div>';
    } else {
      // No diploma found.
      echo '<div class="alert alert-danger" role="alert">';
      echo "<h4 class='alert-heading'>Désolé</h4>";
      echo "<p>Il n'y a aucun diplome avec ce numéro.</p>";
      echo '</div>';
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
    ?>
    <a href="verify.php" class="btn btn-secondary">Retour</a>
  </div>
</body>
</html>
