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
    <link rel="stylesheet" href="../../assets/css/cadastroClientes.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <script src="../../assets/js/functions.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"></script>
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
        <h2>Cadastro de clientes</h2>
        <form action="../../assets/php/valida_cadastro_cliente.php" method="POST" id="cadastroForm">
        <label for="nome">Nome Completo</label>
        <input type="text" id="nome" name="nome" required>

        <label for="telefone">CPF</label>
        <input type="text" id="cpf" name="cpf" required>

        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="telefone" required>

        <label for="cep">CEP</label>
        <input type="text" id="cep" name="cep" required onblur="buscarCEP()">

        <label for="cidade">Cidade</label>
        <input type="text" id="cidade" name="cidade" required>

        <label for="estado">Estado</label>
        <input type="text" id="estado" name="estado" required>
 
        <label for="endereco">Endereço</label>
        <input type="text" id="endereco" name="endereco" required>

        <button type="submit">Cadastrar</button>
    </form>
    </div>
</div>

</body>
</html>

<script>
    $(document).ready(function () {
    // Aplica a máscara ao campo de CEP
    $('#cep').inputmask('99999-999');
    $('#cpf').inputmask('999.999.999-99');
    $('#telefone').inputmask('(99) 99999-9999');
});
$('#nome').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
        $('#endereco').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
        $('#cidade').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
        $('#estado').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
</script>