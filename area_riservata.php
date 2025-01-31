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
    <title>Area riservata</title>
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

            // se chiudo gli oggetti del db qui, non posso eseguire altre query.
            // servce un modo per riaprili in caso di necessità
            //$stmt->close();
            //$conn->close();

        ?>

    </table>

    <h2>Elenco utenti</h2>
    <div>

        <?php 
        
        echo 'TEST caricamento utenti<br>';

        // imposto query SQL
        $sql = "SELECT username FROM utenti WHERE 1 ORDER BY username";

        // preparo la query e i parametri
        $stmt = $conn->prepare($sql);
        //$stmt->bind_param(); // s str i int f float b blob

        // eseguo la query
        if($stmt->execute()){
            echo 'TEST, Ok query eseguita<br>';
        } else {
            echo 'Errore ' . $stmt->error;
        }

        // prendo il result set della query
        $result = $stmt->get_result();

        echo 'TEST Numero righe restituite ' . $result->num_rows . '<br>';

        // se ci sono, carico i irisultati in una lista non ordinata
        if ($result->num_rows>0){
            echo "<ul>";

            // loop sui risultati, per ogni utente aggiungo un elemento alla lista
            while($utente = $result->fetch_assoc()){
                echo "<li>" . $utente['username'] . "</li>"; 
            }
    
            echo "</ul>";
        } else {
            echo 'Nessun utente presente'; // qui non ci arriva mai: all'area riservata si arriva solo se loggati
        }

        // libero risorse
        $stmt->close();
        $conn->close();

        ?>

    </div>

</body>
</html>