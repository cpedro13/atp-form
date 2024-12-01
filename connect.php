<?php

$host = "localhost";
$user = "root";
$pass = "root";
$db = "login";

$conn = new mysqli($host, $user, $pass, $db);  

if ($conn->connect_error) {
    echo "Erro ao conectar ao banco de dados: " . $conn->connect_error;
}
?>

