<?php
session_start();
require '../../assets/php/conexao.php';
require '../../assets/php/verificaAdmin.php';
$conn = conectarAoBanco();

// Verifique se o usuário é um administrador
if (!isAdmin()) {
    // Se não for um administrador, redirecione para outra página ou exiba uma mensagem de erro
    header("Location: ../../views/autenticado/home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/agendamentos.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Home</title>
</head>
<body>

<div class="container">
    <div class="sidebar">
    <img src="../../assets/img/logo-sidebar.png" alt="">
        <ul>
        <li><a href="../../views/admin/home.php">Página Inicial</a></li>
            <li><a href="../../views/admin/cadastroClientes.php">Cadastro de clientes</a></li>
            <li><a href="../../views/admin/clientes.php">Agendar</a></li>
            <li><a href="../../views/admin/galeria.php">Galeria de clientes</a></li>
            <li><a href="../../views/admin/historicoAgendamentos.php">Histórico de Agendamentos</a></li>
            <li><a href="../../assets/php/logout.php">Sair</a></li>
        </ul>
    </div>

    <div class="content">
    <h2>Cadastro de Agendamento</h2>
 

    <form action="../../assets/php/valida_cadastro_agendamento.php" method="POST">
        <label for="cliente">Cliente</label>
        <select id="cliente" name="cliente" required disable>
            <?php
             require '../../assets/php/conexao.php';
            // Conecta ao banco de dados (substitua com suas configurações)
            $conn = conectarAoBanco();

            // Verifica se a conexão foi estabelecida com sucesso
            if ($conn->connect_error) {
                die("Erro na conexão com o banco de dados: " . $conn->connect_error);
            }
            $clienteId = isset($_GET['id']) ? $_GET['id'] : null;

            // Consulta os clientes
            $result = $conn->query("SELECT id, concat(nome_completo, ' - ' , cpf) as nome_completo FROM clientes where id = $clienteId");

            // Preenche as opções do select com os clientes
            while ($row = $result->fetch_assoc()) {
                echo "<option disable value='" . $row['id'] . "'>" . $row['nome_completo'] . "</option>";
                
            }
            $conn->close();
            ?>
        </select>

        <label for="data_agendamento">Data do Agendamento</label>
        <input type="datetime-local" id="data_agendamento" name="data_agendamento" required>

        <label for="tipo_procedimento">Tipo de Procedimento</label>
        <input type="text" id="tipo_procedimento" name="tipo_procedimento" required>

        <label for="observacoes">Observações</label>
        <textarea id="observacoes" name="observacoes" rows="3"></textarea>

        <label for="valor">Valor a receber</label>
        <input type="int" id="valor" name="valor" required>
        <a href="../../views/admin/clientes.php" ><button type="button" style="background:red">Voltar</button></a>
        <button type="submit">Agendar</button>
    </form>
        
    </div>
</div>

</body>
</html>
