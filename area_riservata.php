<?php 
session_start();

require 'db.php';

// devi essere loggato
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit;
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area riservataa</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function conferma_logout(){

            // chiedo conferma all'utente per eseguire il logout, se l'utente annulla impedisco il refresh della pagina (javascript maledetto)
            if (confirm("Sicuro di voler uscire?")){
                window.location.href='logout.php';
            } else {
                event.preventDefault();
            }

        }
    </script>
</head>
<body>
    <h1>Gestione fumetti</h1>
    <a href="nuovo.php">Nuovo</a>
    <!-- <a href="logout.php">Logout</a> -->
    <a href="logout.php" onclick="conferma_logout()">Logout</a>

    <br><br>
    
    <table>
        <tr>
            <th>codice</th>
            <th>descrizione</th>
            <th>modifica</th>
            <th>elimina</th>
        </tr>

        <?php 
            $sql = "SELECT * FROM fumetti ORDER BY CODICE";

            $stmt=$conn->prepare($sql);

            //$stmt->bind_param(); ora non ci sono parametri, s string i int, d double, b blob binary
            if ($stmt->execute()){
                //echo "Ok"; // test
            } else {
                echo "Errore " . $stmt->error;
            }

            $result = $stmt->get_result();

            while($fumetto = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $fumetto['CODICE']. "</td>";
                echo "<td>" . $fumetto['DESCRIZIONE']. "</td>";
                echo "<td><a href='modifica.php?modifica=" . $fumetto['CODICE'] . "'>Modifica</a></td>";
                echo "<td><a href='elimina.php?elimina=" . $fumetto['CODICE'] . "'>Elimina</a></td>";
                
                echo "</tr>";
            }

            $stmt->close();
            $conn->close();

        ?>

    </table>

</body>
</html>