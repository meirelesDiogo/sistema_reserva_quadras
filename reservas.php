<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['cod_cliente'])) {
    header("Location: index.php");
    exit();
}

$msg = "";
$cliente_id = $_SESSION['cod_cliente'];

// Processar Nova Reserva
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reservar'])) {
    $cod_quadra = $_POST['quadra'];
    $data_reserva = $_POST['data_reserva'];

    if (!empty($cod_quadra) && !empty($data_reserva)) {
        $sql = "INSERT INTO reserva (data_reserva, cod_quadra, cod_cliente) VALUES ('$data_reserva', '$cod_quadra', '$cliente_id')";
        if ($conn->query($sql) === TRUE) {
            $msg = "<div class='msg-sucesso'>Reserva realizada com sucesso!</div>";
        } else {
            $msg = "<div class='msg-erro'>Erro ao reservar: " . $conn->error . "</div>";
        }
    }
}

// Buscar Quadras cadastradas para o Select
$quadras = $conn->query("SELECT * FROM quadra");

// Buscar Reservas existentes (Join para trazer nome do cliente e da quadra)
$reservas = $conn->query("SELECT r.cod_reserva, r.data_reserva, q.nome_quadra, c.nome_cliente 
                          FROM reserva r 
                          JOIN quadra q ON r.cod_quadra = q.cod_quadra
                          JOIN cliente c ON r.cod_cliente = c.cod_cliente
                          ORDER BY r.data_reserva DESC");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Reservas</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos específicos complementares para a estrutura de navegação do painel */
        body {
            display: block; /* Sobrescreve o flex de centralização apenas nesta página */
        }
        
        .navbar {
            background-color: #0a0a0a;
            border-bottom: 1px solid #1f1f1f;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .navbar .logo span {
            color: #ff6600;
        }

        .navbar .usuario-info {
            font-size: 14px;
            color: #888888;
        }

        .navbar .btn-sair {
            color: #ff3333;
            text-decoration: none;
            margin-left: 15px;
            font-weight: 500;
            transition: color 0.15s ease;
        }

        .navbar .btn-sair:hover {
            color: #ff6600;
            text-decoration: underline;
        }

        .conteudo-painel {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .secao-form {
            background-color: #0a0a0a;
            border: 1px solid #1f1f1f;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 40px;
        }

        .separador-campos {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .msg-sucesso {
            background-color: rgba(46, 204, 113, 0.1);
            border: 1px solid rgba(46, 204, 113, 0.2);
            color: #2ecc71;
            padding: 12px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .linha-divisoria {
            border: 0;
            border-top: 1px solid #1f1f1f;
            margin: 40px 0;
        }

        @media (max-width: 768px) {
            .separador-campos {
                grid-template-columns: 1fr;
            }
            .navbar {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">CONTROL<span>QUADRAS</span></div>
        <div class="usuario-info">
            Olá, <strong><?php echo htmlspecialchars($_SESSION['nome_cliente']); ?></strong>
            <a href="logout.php" class="btn-sair">Sair do sistema</a>
        </div>
    </nav>

    <div class="conteudo-painel">
        
        <div class="secao-form">
            <h2>Fazer um agendamento</h2>
            <p class="subtitulo" style="margin-bottom: 20px;">Escolha a quadra desejada e defina o horário do seu jogo.</p>
            
            <?php echo $msg; ?>
            
            <form action="" method="POST">
                <div class="separador-campos">
                    <div class="campo">
                        <label for="quadra">Selecione a Quadra</label>
                        <select name="quadra" id="quadra" style="width: 100%; padding: 12px 14px; border: 1px solid #1f1f1f; background-color: #121212; color: #ffffff; border-radius: 6px; font-size: 14px; outline: none; transition: all 0.2s ease;" required onfocus="this.style.borderColor='#ff6600'" onblur="this.style.borderColor='#1f1f1f'">
                            <option value="">-- Escolha uma opção --</option>
                            <?php while($q = $quadras->fetch_assoc()) { ?>
                                <option value="<?php echo $q['cod_quadra']; ?>"><?php echo $q['nome_quadra']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="data_reserva">Data e Hora do Agendamento</label>
                        <input type="datetime-local" id="data_reserva" name="data_reserva" required>
                    </div>
                </div>

                <button type="submit" name="reservar" class="btn-entrar" style="max-width: 220px;">Confirmar Agendamento</button>
            </form>
        </div>

        <hr class="linha-divisoria">

        <div class="painel-reservas" style="padding: 0; background: transparent; border: none;">
            <h2>Agendamentos realizados</h2>
            <p class="subtitulo" style="margin-bottom: 10px;">Lista de horários reservados no sistema por todos os usuários.</p>
            
            <table>
                <thead>
                    <tr>
                        <th style="width: 100px;">Código</th>
                        <th>Cliente</th>
                        <th>Quadra Selecionada</th>
                        <th>Data / Hora do Jogo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($reservas->num_rows > 0) { 
                        while($res = $reservas->fetch_assoc()) { ?>
                            <tr>
                                <td>#<?php echo $res['cod_reserva']; ?></td>
                                <td><?php echo htmlspecialchars($res['nome_cliente']); ?></td>
                                <td><span style="color: #ffffff; font-weight: 500;"><?php echo htmlspecialchars($res['nome_quadra']); ?></span></td>
                                <td><?php echo date('d/m/Y - H:i', strtotime($res['data_reserva'])); ?> H</td>
                            </tr>
                        <?php } 
                    } else { ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #666666; padding: 30px;">Nenhum agendamento foi localizado no sistema até o momento.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
    </div>

</body>
</html>