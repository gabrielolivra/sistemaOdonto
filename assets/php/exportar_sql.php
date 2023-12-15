<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<?php
session_start();
ob_start();
//Receber os dados do formulário
$servidor = $_POST['servidor'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$dbname = $_POST['dbname'];

//Criar a conexao com BD
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

//Incluir o arquivo que gerar o backup
include_once("gerar_backup.php");

$_SESSION['backup_status'] = file_exists($nome_arquivo . '.sql') ? 'success' : 'error';

// Voltar para a página anterior
header("Location: " . $_SERVER['HTTP_REFERER']);

?>
