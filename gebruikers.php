
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



$stmt = $conn->prepare("SELECT * FROM gebruikers");
if ($stmt->execute()===false){
    throw new Exception($stmt->error);
 }

$stmt->execute();

$result = $stmt->get_result();
$gebruikers=$result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikers</title>
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
  
        <h1 class="Title">Gebruikers</h1>

</body>
</html>
<?php
function haalgebruiker(){
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname ="films";

    try{
    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->connect_error){
        throw new Exception("Connection failed:".$conn->connection_error);
    }
    $query="SELECT id, naam, email,wachtwoord FROM gebruikers";
    $stmt=$conn->prepare($query);
    $stmt->execute();
    $stmt->bind_result($id,$naam,$email,$wachtwoord);

    echo "<table border='1' cellpadding='5' cellspacing='0' class='table table-striped-columns'>";
    echo "<tr><th>Naam</th>
    <th>E-mail</th><th>Opties</th>
   
    </tr>";

    while($stmt->fetch())
    {
        echo "<tr>";
        echo "<td>".htmlspecialchars($naam)."</td>";
        echo "<td>".htmlspecialchars($email)."</td>";
        echo "<td> <a href='update.php?id=" . htmlspecialchars($id) . "'>update</a></td>";
          echo "<td> <a href='delete.php?id=" . htmlspecialchars($id) . "'>delete</a></td>";
       
        echo "</tr>";
    }
    echo "</table>";
    echo "<td>";
    
    $stmt->close();
    $conn->close();

    }
    catch(Exception $e){
        echo "Mijn error;".$e->getMessage();

    }
}
haalgebruiker();
?>
