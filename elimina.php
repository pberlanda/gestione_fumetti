<?php 
session_start();

require 'db.php';

// devi essere loggato
if (!isset($_SESSION['loggedin'])){
    header('Location: admin.php');
    exit;
}

// verifica se passato codice da eliminare
if(isset($_GET['elimina'])){
    $codice = $_GET['elimina'];

    echo "TEST codice da eliminare " . $codice;

}

// gestione eliminazione
if($_SERVER['REQUEST_METHOD'] == "POST"){

    $sql = ("DELETE FROM fumetti WHERE CODICE = ?");

    $stmt = $conn->prepare($sql);

    $stmt->bind_param('s', $codice); // s string

    $stmt->execute();

    $stmt->close();
    $conn->close();

    header('Location: admin.php');

}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimina</title>
</head>
<body>
    <h1>Elimina</h1>

    <form method="POST">
        <input type="text" name="delete_codice" value="<?php echo $codice ?>" disabled>

        <input type="submit" value="Elimina" onclick=confirm("Sicuro?")>
    </form>

    <a href="admin.php">Torna all'area riservata</a>

</body>
</html>