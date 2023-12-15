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
    <link rel="icon" href="../../assets/img/logo-sidebar.png" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/homeAdmin.css">
    <link rel="stylesheet" href="../../assets/css/backup.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Home</title>
</head>
<body>

<div class="container">
    
<div class="test">
    <div class="sidebar">
        <img src="../../assets/img/logo-sidebar.png" alt="">
        <ul>
        <li><a href="../../views/admin/home.php">Página Inicial</a></li>
            <li><a href="../../views/admin/cadastroClientes.php">Cadastro de clientes</a></li>
            <li><a href="../../views/admin/listClientes.php">Meus clientes</a></li>
            <li><a href="../../views/admin/clientes.php">Agendar</a></li>
            <li><a href="../../views/admin/listAgendamentos.php">Agendamentos</a></li>            
            <li><a href="../../views/admin/galeria.php">Galeria de clientes</a></li>
            <li><a href="../../views/admin/historicoAgendamentos.php">Histórico de Agendamentos</a></li>
            <li><a href="../../views/admin/saldo.php">Prestação de contas</a></li>
            <li><a href="../../assets/php/logout.php">Sair</a></li>
        </ul>
    </div>
</div>

    <div class="content">
    
    <h2>Fazer backup da aplicação</h2>
    <?php
        if (isset($_SESSION['backup_status'])) {
            $mensagem = 'Backup realizado com sucesso!';
            // Exibir a mensagem
            echo "<script>alert('$mensagem');</script>";
        
            // Limpar a variável de sessão
            unset($_SESSION['backup_status']);
        }
       
        $conn = mysqli_connect('localhost', 'root', '', 'sistema');

        // Consultar a última data de backup
        $query = "SELECT MAX(data_backup) AS ultima_data FROM backup_control";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $ultimaDataBackup = $row['ultima_data'];?>

    <form action="../../assets/php/exportar_sql.php" method="post">
        <?php  echo "<p>O ultimo  backup que você fez foi no dia: $ultimaDataBackup</p>"; ?>
    <!-- Campos ocultos com valores predefinidos -->
    <input type="hidden" name="servidor" value="localhost">
    <input type="hidden" name="usuario" value="root">
    <input type="hidden" name="senha" value="">
    <input type="hidden" name="dbname" value="sistema">
    <!-- Botão para exportar -->
    <button type="submit" name="exportar">Exportar dados para o computador</button>
</form>

</div>
</body>
</html>
