<?php 
session_start();

require 'db.php';
// esegue login se è stato immesso nome utente e pwd nei campi login
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = ("SELECT * FROM utenti WHERE username = ?");

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s',$username); // s string i int d double b blob

    if($stmt->execute()){
        //echo "Ok"; // test
    } else {
        echo "Error " . $stmt->error;
    }

    $result = $stmt->get_result();

/*     while($usr=$result->fetch_assoc()){
        $utente_username = $usr['username'];
        $utente_password = $usr['password'];
    }*/

    // non serve fare il ciclo while su un result set che contiene una sola tupla
    $usr = $result->fetch_assoc();
    $utente_username = $usr['username'];
    $utente_password = $usr['password'];

    // controllo nome utente e pwd immessi
    if ($username == $utente_username && password_verify($password, $utente_password)){
        echo "ciao"; // qui arriva, quindi il controllo pwd funziona
        $_SESSION['loggedin'] = true;
        header('Location: admin.php');
        exit;
    } else {
        echo 'Username o password errata';
    }

    // libero risorse
    $stmt->close();
    $conn->close();

}

// crea nuovo utente se sono stati immessi nome utente e pwd nei campi registrazione
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['reg_username']) && isset($_POST['reg_password'])){
    $regUsername=$_POST['reg_username'];
    $regPassword=$_POST['reg_password'];

    //echo "check"; // test

    // creo hash della pwd
    $hashedPassword = password_hash($regPassword,PASSWORD_DEFAULT);

    $stmt=$conn->prepare('INSERT INTO utenti (USERNAME, PASSWORD) VALUES(?,?)');
    $stmt->bind_param('ss', $regUsername, $hashedPassword);

    if($stmt->execute()){
        $_SESSION['loggedin']=true;
        echo "Ok, utente creato";
        header('Location: login.php');
        exit;
   
    } else {
        echo "Errore " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <form method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" required>

        <label for="password">Username</label>
        <input type="password" name="password" required>

        <input type="submit" value="login">
    </form>

    <form method="POST">
        <label for="reg_username">Username</label>
        <input type="text" name="reg_username" required>

        <label for="reg_password">Password</label>
        <input type="password" name="reg_password" required>

        <input type="submit" value="Registrati" onclick=confirm("Confermi?")>

    </form>

    <a href="index.php">Torna a home page</a>

</body>
</html>