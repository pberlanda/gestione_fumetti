<?php 

require 'db.php';

if($_SERVER['REQUEST_METHOD']=="POST" || isset($_POST['Nuovo'])){
    $codice=$_POST['codice'];
    $descrizione=$_POST['descrizione'];

    $stmt=$conn->prepare("INSERT INTO fumetti (CODICE, DESCRIZIONE) VALUES (?,?)");
    $stmt->bind_param('ss', $codice, $descrizione);

    if($stmt->execute()){
        //echo"Ok"; // test
    } else {
        echo"Errore " . $stmt->error;
    }

}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione libri con login</title>
</head>
<body>
    <h1>Gestione fumetti</h1>

    <a href="admin.php">Area riservata</a><br><br>

    <form method="POST">
        <label for="codice">Codice</label>
        <input type="text" name="codice" required>

        <label for="descrizione">Descrizione</label>
        <input type="text" name="descrizione" required>

        <input type="submit" value="Nuovo">
    </form>

    <table>
        <tr>
            <th>Codice</th>
            <th>Descrizione</th>
        </tr>

        <?php 
            $sql = "SELECT * FROM fumetti ORDER BY CODICE";
            $result = $conn->query($sql);

            while($fumetto = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $fumetto['CODICE'] . "</td>";
                echo "<td>" . $fumetto['DESCRIZIONE'] . "</td>";
                echo "</tr>";
            }

        ?>

    </table>

</body>
</html>