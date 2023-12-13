<?php

require '../../assets/php/conexao.php';
require '../../assets/php/functions.php';

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar os dados do formulário
    $cliente = $_POST["cliente"];
    $dataAgendamento = $_POST["data_agendamento"];
    $tipoProcedimento = $_POST["tipo_procedimento"];
    $observacoes = $_POST["observacoes"];
    $valor = $_POST["valor"];

    // Chamar a função para agendar
    agendar($cliente, $dataAgendamento, $tipoProcedimento, $observacoes, $valor);

    // Redirecionar ou realizar qualquer outra ação após o agendamento
    header("Location: ../../views/admin/home.php");
    exit();
} else {
    // Redirecionar ou exibir uma mensagem de erro, dependendo do caso
    header("Location: erro.php");
    exit();
}

?>
