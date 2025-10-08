<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetophp</title>
</head>
<body>
    <form action="projeto.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome"><br><br>

        <label for="idade">Idade:</label>
        <input type="text" id="idade" name="idade"><br><br>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf"><br><br>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>


<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projetophp";

    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $cpf = $_POST["cpf"];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $insert = $conn->prepare("insert into usuario (cpf, nome, idade) values(:cpf, :nome, :idade)");
        $insert->execute([":nome" => $nome, ":idade" => $idade, ":cpf"=> $cpf]);

    } 

    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
