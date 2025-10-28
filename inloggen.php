<?php

session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['wachtwoord'] ?? '';

    $stmt = $conn->prepare("SELECT id, wachtwoord FROM gebruikers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword);

    if ($stmt->fetch()) {
        if (password_verify($password, $hashedPassword)) {
            
            $_SESSION['userId'] = $userId;

            
            header("Location: index.php");
            exit;
        } else {
            echo "Verkeerd wachtwoord.";
        }
    } else {
        echo "Gebruiker niet gevonden.";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>
   <nav class="navbar navbar-expand-lg " 
    style="background-color: #b6d4c5ff;" data-bs-theme="light">  
  <div class="container-fluid">
     <a class="logo" href="index.php">
        <img src="img/Frame2.png" alt="Logo"width="60" height="50"></a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="toevoegen.php">Film toevoegen</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="gebruikers.php">Gebruikers</a>
        </li>
         
        </ul>
    </div>
  </div>
</nav>

    <h1 class="title">Inloggen</h1>

<form action="inloggen.php" method="POST" class="aa">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label" >Email address</label>
    <input type="email" class="form-control" id="email" name="email"placeholder="name@example.com"required>
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Wachtwoord</label>
    <input type="password" class="form-control" name="wachtwoord" id="wachtwoord" required>
  </div>

   <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Herhaal Wachtwoord</label>
    <input type="password" class="form-control"name="wachtwoordherhaal" id="wachtwoordherhaal" required>
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<div class="a2">
    <a class="btn btn-primary" href="inschrijven.php" role="button">Inschrijven</a>

</div>



      
    
</body>
</html>
