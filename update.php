
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toevoegen</title>
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
  
        <h1 class="title">Update</h1>
 </body>
</html> 

<?php
//start sessie
session_start();

//link naar database
require_once 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

//als form via post is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id=$_POST['id'];
    $naam = $_POST['naam']  ;
    $email = $_POST['email'];

 //query om uit te voeren
 try{
    $query="UPDATE gebruikers SET  naam=?, email=?  WHERE id=?";
    $stmt->$conn->prepare($query);

    $stmt->bind_param("ssi",$naam,$email,$id);
    $stmt->execute();

    $stmt->close();
     header('Location: gebruikers.php');
     exit;
 } catch(mysqli_sql_exception $e){
    echo "Mijn error;". $e->getMessage();
  }
}if (!isset($_GET['id'])) {
  die("Geen userID opgegeven.");
}

$id=$_GET['id'];

try{
  
  $stmt=$conn->prepare("SELECT naam,email FROM gebruikers WHERE id = ?");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  $stmt->bind_result($naam,$email);

  

   if ($stmt->fetch()) {
    $naam = '';
    $email ='';
   

    //formulier om een boek te updaten
     ?>
    <form action="update.php" method="POST" class="aa">

    <div class="mb-3">
    <label for="exampleInputName1" class="form-label" >Naam</label>
    <input type="text" class="form-control"name="naam" id="naam">

    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label" >Email address</label>
    <input type="email" class="form-control" id="email" name="email" required>
    

  <button type="submit" class="btn btn-primary">Update</button>
   </form>
   <?php
 }  
 $stmt->close();
} catch(mysqli_sql_exception $e){
  echo "Mijn error;". $e->getMessage();
}finally{
  $conn->close();
}
?>