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

        <label for="numero_cell">numero de celular:</label>
        <input type="text" id="numero_cell" name="numero_cell"><br><br>

        <label for="endereco">endereco:</label>
        <input type="text" id="endereco" name="endereco"><br><br>

        <label for="email">endereco:</label>
        <input type="text" id="email" name="email"><br><br>

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
    $numero_cell = $_POST["numero_cell"];
    $endereco = $_POST["endereco"];
    $email = $_POST["email"];


    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $insert = $conn->prepare("insert into usuario (cpf, nome, idade, numero_cell, endereco) values(:cpf, :nome, :idade, :numero_cell, :endereco)");
        $insert->execute([":nome" => $nome, ":idade" => $idade, ":cpf"=> $cpf, ":numero_cell" => $numero_cell, ":endereco" => $endereco]);

    } 

    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
