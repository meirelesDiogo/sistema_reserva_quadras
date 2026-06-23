<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema_reserva_quadras";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>