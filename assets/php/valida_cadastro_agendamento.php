<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Agendamentos</title>
</head>
<body>
    
</body>
</html>

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
    echo '
    <script>
        // Adicione um listener para o envio do formulário
       // Impede o envio padrão do formulário

            // Simula uma resposta bem-sucedida do servidor
            // Substitua isso pela lógica real do seu servidor
            Swal.fire({
                icon: "success",
                title: "Agendamento realizado com sucesso!",
                showConfirmButton: false,
                timer: 2500
            }).then(() => {
                // Redireciona para a página de clientes após a notificação
                window.location.href = "../../views/admin/meusAgendamentos.php";
            });
        
    </script>';
    // Redirecionar ou realizar qualquer outra ação após o agendamento
    
    exit();
} else {
    // Redirecionar ou exibir uma mensagem de erro, dependendo do caso
    echo '
    <script>
        // Adicione um listener para o envio do formulário
       // Impede o envio padrão do formulário

            // Simula uma resposta bem-sucedida do servidor
            // Substitua isso pela lógica real do seu servidor
            Swal.fire({
                icon: "error",
                title: "Erro ao realizar agendamento!",
                showConfirmButton: false,
                timer: 2500
            }).then(() => {
                // Redireciona para a página de clientes após a notificação
                window.location.href = "../../views/admin/clientes.php";
            });
        
    </script>';
    exit();
}

?>
