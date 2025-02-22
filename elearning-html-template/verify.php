<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vérification du Diplome</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Optional styling for the input bar */
    .verify-container {
      max-width: 400px;
      margin: 100px auto;
    }
  </style>
</head>
<body>
  <div class="container verify-container">
    <h2 class="mb-4 text-center">Vérification du Diplome</h2>
    <form action="process_verification.php" method="post">
      <div class="mb-3">
        <input type="text" class="form-control" id="numero_diplome" name="numero_diplome" placeholder="Entrez votre numéro de diplôme" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Verify</button>
    </form>
  </div>
</body>
</html>
