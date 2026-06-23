<?php
session_start();
include_once('conexao.php');

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapando as strings para proteger o banco de dados contra quebras e invasões simples
    $nome    = $conn->real_escape_string($_POST['nome']);
    $tel     = $conn->real_escape_string($_POST['tel']);
    $end     = $conn->real_escape_string($_POST['end']);
    $usuario = $conn->real_escape_string($_POST['login']);
    $senh    = $_POST['senha'];
    
    // Criptografia correta e segura
    $senha = password_hash($senh, PASSWORD_DEFAULT);

    $manda = mysqli_query($conn, "INSERT INTO cliente (nome_cliente, telefone, endereco, usuario, senha) VALUES ('$nome', '$tel', '$end', '$usuario', '$senha')");

    if ($manda) {
        $msg = "<div class='msg-sucesso'>Cadastro realizado com sucesso! Redirecionando para o login...</div>";
        header("Refresh: 2; url=index.php");
    } else {
        $msg = "<div class='msg-erro'>Erro ao cadastrar: Usuário já existe ou dados inválidos. Tente novamente.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Reserva de Quadras</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos específicos para formatar a caixinha de aviso de sucesso do cadastro */
        .msg-sucesso {
            background-color: rgba(46, 204, 113, 0.1);
            border: 1px solid rgba(46, 204, 113, 0.2);
            color: #2ecc71;
            padding: 12px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 20px;
            font-weight: 500;
            text-align: center;
        }
    </style>
</head>
<body>

    <form method="POST" class="box-login" id="cadastroForm" style="max-width: 450px;">
        <h2>Crie sua conta</h2>
        <p class="subtitulo">Preencha os campos abaixo para começar a agendar suas quadras.</p>
        
        <?php echo $msg; ?>
        
        <div class="campo">
            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" name="nome" placeholder="ex: Douglas Silva" required>
        </div>

        <div class="campo">
            <label for="tel">Telefone / Celular</label>
            <input type="tel" id="tel" name="tel" placeholder="ex: (31) 98569-8965" required>
        </div>

        <div class="campo">
            <label for="end">Endereço Residencial</label>
            <input type="text" id="end" name="end" placeholder="Rua, número, bairro" required>
        </div>

        <div class="campo">
            <label for="login">Nome de Usuário (Login)</label>
            <input type="text" id="login" name="login" autocomplete="off" placeholder="O usuário que usará no login" required>
        </div>
        
        <div class="campo">
            <label for="senha">Crie uma Senha</label>
            <input type="password" id="senha" name="senha" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-entrar">Criar minha conta</button>
        
        <a href="index.php" class="link-cadastro">Já tem um cadastro? Faça login aqui</a>
    </form>

    <script>
        // Validação front-end rápida antes de submeter
        document.getElementById('cadastroForm').addEventListener('submit', function(e) {
            let campos = document.querySelectorAll('input[required]');
            let valido = true;
            
            campos.forEach(function(campo) {
                if (campo.value.trim() === "") {
                    valido = false;
                }
            });

            if (!valido) {
                e.preventDefault();
                alert("Por favor, preencha todos os campos corretamente.");
            }
        });
    </script>
</body>
</html>