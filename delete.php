<?php

require_once 'config.php';
$conn = new mysqli($servername, $username, $password, $dbname);

   
if (!isset($_GET['id'])) {
  die("Geen userID opgegeven.");
}

$id=$_GET['id'];

try{
//   gebruiker verwijderen
  $stmt=$conn->prepare("DELETE FROM gebruikers WHERE id =?");
  $stmt->bind_param("i",$id);
  $stmt->execute();

  echo "Gebruiker verwijderd. <a href='gebruikers.php'>Terug naar overzicht</a>";

 $stmt->close();
} catch(mysqli_sql_exception $e){
  echo "Mijn error;". $e->getMessage();
}finally{
  $conn->close();
}
?>