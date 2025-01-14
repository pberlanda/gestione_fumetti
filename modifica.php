<?php
session_start();

require 'db.php';

// devi essere loggato
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit;
}

if (isset($_GET['modifica'])){

    $codice = $_GET['modifica'];

    echo "TEST modifica codice " . $codice;

}

// gestione modifica
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $edit_descrizione = $_POST['edit_descrizione'];

    echo "TEST paarmetri per query update " . $codice . " " . $edit_descrizione;

    $sql = ("UPDATE fumetti SET DESCRIZIONE = ? WHERE CODICE = ?");

    $stmt = $conn->prepare($sql);

    $stmt->bind_param('ss', $edit_descrizione, $codice);

    if($stmt->execute()){
        echo "TEST Ok, update fatto";
    } else {
        echo "Errore " . $stmt->error;
    }

    header('Location: admin.php');

    //$stmt->close();
    //$conn->close();

}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica fumetto</title>
</head>
<body>
    <h1>Modifica fumetto</h1>

    <?php 
    
    $sql = ("SELECT * FROM fumetti WHERE CODICE = ?");

    $stmt = $conn->prepare($sql);

    $stmt->bind_param('s', $codice);

    if($stmt->execute()){
        echo "TEST Ok, lettura eseguita"; // test
    } else {
        echo "Error " . $stmt->error;
    }

    $result = $stmt->get_result();

    $fumetto = $result->fetch_assoc();

    echo "<br>TEST fumetto da modificare " . $fumetto['CODICE'] . " " . $fumetto['DESCRIZIONE'] . "<br>";

    ?>

    <form method="POST">
        <label><?php echo $codice ?></label>
        <input type="text" name="edit_descrizione" value="<?php echo $fumetto['DESCRIZIONE'] ?>">
        
        <input type="submit" value="Modifica" onclick=confirm('Sicuro?')>
    </form>

    <a href="admin.php">Torna all'area riservata</a>

</body>
</html>