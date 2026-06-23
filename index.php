<?php
session_start();
include('conexao.php');

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $senha_digitada = $_POST['senha'];

    $sql = "SELECT cod_cliente, nome_cliente, senha FROM cliente WHERE usuario = '$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $senha_banco = $row['senha'];

        if (password_verify($senha_digitada, $senha_banco)) {
            $_SESSION['cod_cliente'] = $row['cod_cliente'];
            $_SESSION['nome_cliente'] = $row['nome_cliente'];
            header("Location: reservas.php");
            exit();
        } else {
            $erro = "Usuário ou senha inválidos.";
        }
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - Reserva de Quadras</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <form action="" method="POST" class="box-login" id="loginForm">
        <h2>Inicie sessão</h2>
        <p class="subtitulo">Introduza as suas credenciais para gerir reservas.</p>
        
        <?php if($erro != "") { echo "<div class='msg-erro'>$erro</div>"; } ?>
        
        <div class="campo">
            <label for="usuario">Nome de usuário</label>
            <input type="text" id="usuario" name="usuario" autocomplete="off" placeholder="ex: douglas" required>
        </div>
        
        <div class="campo">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-entrar">Entrar</button>
        
        <a href="cadastrar.php" class="link-cadastro">Não tem uma conta? Registe-se aqui</a>
    </form>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            let u = document.getElementById('usuario').value.trim();
            let s = document.getElementById('senha').value.trim();
            if(u === "" || s === "") {
                e.preventDefault();
                alert("Por favor, preencha todos os campos.");
            }
        });
    </script>
</body>
</html>