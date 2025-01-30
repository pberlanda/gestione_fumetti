
<?php 
$server="localhost";
$username="root";
$password="";
$dbName="gestione_fumetti";

$conn = new mysqli($server,$username,$password,$dbName);

if($conn->connect_error){
    die("Errore " . $connect_error);
}

?>