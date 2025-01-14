
<?php 
$server="localhost";
$username="root";
$password="";
$dbName="gestione_libri";

$conn = new mysqli($server,$username,$password,$dbName);

if($conn->connect_error){
    die("Errore " . $connect_error);
}

?>