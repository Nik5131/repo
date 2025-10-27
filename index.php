<?php

session_start();
require_once 'config.php';


if (!isset($_SESSION['userId'])) {
    header("Location: inloggen.php");
    exit;
}
$userId = $_SESSION['userId'];

$stmt = $conn->prepare("SELECT naam FROM gebruikers WHERE id = ?");

$stmt->bind_param("i", $userId);

$stmt->execute();

$stmt->bind_result($naam);

$stmt->fetch();

$stmt->close();




$stmt = $conn->prepare("SELECT * FROM film");
if ($stmt->execute()===false){
    throw new Exception($stmt->error);
 }

$stmt->execute();

$result = $stmt->get_result();




$films=$result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
          <li class="gebrinlog">
          <a class="nav-link" href=""><img src="img/person-fill.svg" alt="Logo"width="20" height="20"><?php echo htmlspecialchars($naam); ?></a>
        </li>
         <li class="uitloggen">
          <a class="nav-link" href="uitloggen.php"><img src="img/box-arrow-in-left.svg" alt="Logo"width="20" height="20"></a>
        </li>
        </ul>
    </div>
  </div>
</nav>
  
        <h1 class="title2">Films</h1>

        <div class="filmlijst">
  
        <?php foreach ($films as $film): ?>
       <div class="card" style="width: 18rem;">
        <img src="img/<?php echo htmlspecialchars($film['bestand']); ?>" class="card-img-top" alt="img">
        <div class="card-body">
        <h5 class="card-title"><?php echo htmlspecialchars($film['titel']); ?></h5>
        <p class="card-text"><?php echo htmlspecialchars($film['genre']); ?></p>
        <a href="#" class="btn btn-primary">Meer info</a>
    </div>
  </div>
    
      <?php endforeach; ?>
   
    
</body>
</html>