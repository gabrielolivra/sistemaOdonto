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
            <li><a href="../../views/admin/clientes.php">Clientes</a></li>
            <li><a href="../../views/admin/historicoAgendamentos.php">Historico de Agendamentos</a></li>
            <li><a href="../../assets/php/logout.php">Sair</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Historico de agendamentos</h2>
        
       
       
    </div>
</div>

</body>
</html>