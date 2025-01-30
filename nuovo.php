<?php 
session_start();

require 'db.php';

if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['codice'])){

    $codice = $_POST['codice'];
    $descrizione = $_POST['descrizione'];

    // verifico se esistente da implementare
    echo "ciao";

    // scrivo nel db nuovo fumetto
    $sql = "INSERT INTO fumetti(CODICE, DESCRIZIONE) VALUES (?,?)";
    
    $stmt = $conn->prepare($sql);

    $stmt->bind_param('ss', $codice, $descrizione); // s str, i int, d dbl, b blb bin

    if($stmt->execute()){
        echo "Ok"; // solo per test, va eliminato
    } else {
        echo "Errore " . $stmt->error;
    }

    // libera risorse srv
    $stmt->close();
    $conn->close();

    header('Location: area_riservata.php');

    exit;

}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuovo fumetto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Inserisci nuovo fumetto</h1>
<form method="POST">
    <input type="text" name="codice" placeholder="codice" required>
    <input type="text" name="descrizione" placeholder="descrizione" required>

    <input type="submit" value="Nuovo">
</form>

<a href="area_riservata.php">Torna a area riservata</a>
    
</body>
</html>