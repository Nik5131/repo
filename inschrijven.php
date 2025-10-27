<?php
session_start();


require_once 'config.php';


use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('gebruiker');
$log->pushHandler(new StreamHandler(__DIR__ . '/info.log', Level::Info));

$log->info('new gebruiker');



if ($_SERVER["REQUEST_METHOD"] === "POST") {
     $naam = $_POST["naam"]?? '';
    $email = $_POST["email"]?? '';
    $password = $_POST["wachtwoord"]?? '';
    $passwordherhaal = $_POST["wachtwoordherhaal"]?? '';

    
      if (!empty($naam) && !empty($email) && !empty($password)) {
     if ($password !== $passwordherhaal) {
        echo "Wachtwoorden zijn niet de zelfde";}
        else {
            $stmt = $conn->prepare("SELECT id FROM gebruikers WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $stmt->bind_result($userId);

            if ($stmt->fetch()) {
                echo "Dit Email is al gereggistreerd";}
     else {
         $stmt->close();

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO gebruikers (naam, email, wachtwoord) VALUES (?,?,?)");

        $stmt->bind_param("sss", $naam, $email ,$hashedPassword);

      if ($stmt->execute()) {
            echo "Registratie gelukt!";
        } else {
            echo "Fout bij registreren: " . $stmt->error;
        }
   
       $stmt->close();
      }
            
        }
    }
      else{
    echo "Vul alle velden in";
}
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inschrijven</title>
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

    <h1 class="title">Registreer nu </h1>
    
    <form action="inschrijven.php" method="POST" class="aa">

    <div class="mb-3">
    <label for="exampleInputName1" class="form-label" >Naam</label>
    <input type="text" class="form-control"name="naam" id="naam">

    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label" >Email address</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"required>
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Wachtwoord</label>
    <input type="password" class="form-control" name="wachtwoord"id="wachtwoord" required>
  </div>

   <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Herhaal Wachtwoord</label>
    <input type="password" class="form-control" name="wachtwoordherhaal" id="wachtwoordherhaal" required>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
    <div class="a2">
    <a class="btn btn-primary" href="inloggen.php" role="button">Inloggen</a>

</div>
</body>

</html>
<!-- <button type="submit" class="btn btn-primary">Submit</button>
      Naam: <br><input type="text" name="naam"required><br>
      E-mail: <br><input type="text" name="email"required><br>
      Password: <br><input type="password" name="wachtwoord"required><br>
       
     Herhaal Wachtwoord:<br><input type="password" name="wachtwoordherhaal" required><br><br>

     <input type="submit" value="submit"> -->