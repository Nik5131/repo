
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
?>
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
  
        <h1 class="title">Toevoegen</h1>
 </body>
</html> 

<?php


function filmtoevoegen(){
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname ="films";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($_SERVER["REQUEST_METHOD"]==="POST"){

        $titel=$_POST['titel']??'';
        $jaar=$_POST['jaar']??'';
        $genre=$_POST['genre']??'';
        $tijd=$_POST['tijd']??'';
        $taal=$_POST['taal']??'';
        $bestand=$_POST['bestand']??'';

        try{
            $query="INSERT INTO film (titel,jaar,genre,tijd,taal,bestand) VALUES (?,?,?,?,?,?)";
            $stmt=$conn->prepare($query);

            $stmt->bind_param("ssssss",$titel,$jaar,$genre,$tijd,$taal,$bestand);
              if ($stmt->execute()) {
    echo "<p>Film succesvol toegevoegd!</p>";
    } else {
    echo "<p>Fout bij toevoegen: " . $stmt->error . "</p>";
    } 
            
       $stmt->close();
        }
        catch(mysqli_sql_exception $e)
        {
            echo "Mijn error;".
            $e->getMessage();
        }finally{
            $conn->close();
        }
    }else{
        $titel='';
        $jaar='';
        $genre='';
        $tijd='';
        $taal='';
        $bestand='';

        ?>
        

    <form action="toevoegen.php" method="POST" class="aa">

    <div class="mb-3">
  <label for="formGroupExampleInput" class="form-label">Titel</label>
  <input type="text" class="form-control" id="formGroupExampleInput"name="titel">
</div>
   <div class="mb-3">
  <label for="formGroupExampleInput" class="form-label">Jaar</label>
  <input type="text" class="form-control" id="formGroupExampleInput"name="jaar">
</div>
   <div class="mb-3">
  <label for="formGroupExampleInput" class="form-label">Genre</label>
  <input type="text" class="form-control" id="formGroupExampleInput"name="genre">
</div>
   <div class="mb-3">
  <label for="formGroupExampleInput" class="form-label">Tijd</label>
  <input type="text" class="form-control" id="formGroupExampleInput"name="tijd">
</div>
   <div class="mb-3">
  <label for="formGroupExampleInput" class="form-label">Taal</label>
  <input type="text" class="form-control" id="formGroupExampleInput"name="taal">
</div>
  <div class="mb-3">
  <label for="formGroupExampleInput" class="form-label">Bestand</label>
  <input type="text" class="form-control" id="formGroupExampleInput"name="bestand">
</div>
<button type="submit" class="btn btn-primary">Submit</button>
        <!-- <label for="titel">Titel:</label><br>
        <input type="text" name="titel"><br>

         <label for="jaar">Jaar:</label><br>
        <input type="text" name="jaar"><br>

        <label for="genre">Genre:</label><br>
        <input type="text" name="genre"><br>

        <label for="tijd">Tijd:</label><br>
        <input type="text" name="tijd"><br>

        <label for="taal">Taal:</label><br>
        <input type="text" name="taal"><br>

        <label for="director">Director:</label><br>
        <input type="text" name="director"><br> -->

        <!-- <input type="submit" value="toevoegen"><br> -->

    </form>
    <?php
    }    
}
filmtoevoegen();
?>
    
