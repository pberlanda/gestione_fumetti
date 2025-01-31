
<?php 
$server="localhost";
$username="root";
$password="";
$dbName="gestione_fumetti";

// creo la connessione
// ss la connessione è già stata creata, non la ricreo
if (!isset($conn)){
    echo 'TEST la connessione è nulla, quindi la creo<br>';
    $conn = new mysqli($server,$username,$password,$dbName);
}

//$conn = new mysqli($server,$username,$password,$dbName);

if($conn->connect_error){
    die("Errore " . $connect_error);
}

?>