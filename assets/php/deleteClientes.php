<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Excluir clientes</title>
</head>
<body>
    
</body>
</html>

<?php
require '../../assets/php/conexao.php';

// Função para excluir um cliente e registros relacionados
function excluirClienteComRelacionamentos($id_cliente) {
    // Conecta ao banco de dados
    $conn = conectarAoBanco();

    // Inicia uma transação
    $conn->begin_transaction();

    try {
        // 1. Excluir registros relacionados na tabela "agendamentos"
        $sql_agendamentos = "DELETE FROM agendamentos WHERE cliente_id=?";
        $stmt_agendamentos = $conn->prepare($sql_agendamentos);
        $stmt_agendamentos->bind_param("i", $id_cliente);
        $stmt_agendamentos->execute();
        $stmt_agendamentos->close();

        // 2. Excluir registros relacionados na tabela "galeria"
        $sql_galeria = "DELETE FROM galeria WHERE usuario_id=?";
        $stmt_galeria = $conn->prepare($sql_galeria);
        $stmt_galeria->bind_param("i", $id_cliente);
        $stmt_galeria->execute();
        $stmt_galeria->close();

        // 3. Excluir o cliente da tabela "clientes"
        $sql_cliente = "DELETE FROM clientes WHERE id=?";
        $stmt_cliente = $conn->prepare($sql_cliente);
        $stmt_cliente->bind_param("i", $id_cliente);
        $stmt_cliente->execute();
        $stmt_cliente->close();

        // Confirma a transação
        $conn->commit();

        // Retorna true se a exclusão for bem-sucedida
        return true;
    } catch (Exception $e) {
        // Reverte a transação em caso de erro
        $conn->rollback();

        // Retorna false se houver um erro na exclusão
        return false;
    } finally {
        // Fecha a conexão com o banco de dados
        $conn->close();
    }
}

// Verifica se o parâmetro 'id' está presente na URL
if (isset($_GET['id'])) {
    // Obtém o valor do parâmetro 'id' e realiza alguma validação (neste caso, converte para inteiro)
    $id_cliente_a_excluir = intval($_GET['id']);

    // Chama a função para excluir cliente com registros relacionados
    $resultado_exclusao = excluirClienteComRelacionamentos($id_cliente_a_excluir);

    // Verifica o resultado da exclusão
    if ($resultado_exclusao) {
        echo '
        <script>
            // Adicione um listener para o envio do formulário
           // Impede o envio padrão do formulário
    
                // Simula uma resposta bem-sucedida do servidor
                // Substitua isso pela lógica real do seu servidor
                Swal.fire({
                    icon: "success",
                    title: "Cliente excluido com sucesso!",
                    showConfirmButton: false,
                    timer: 2500
                }).then(() => {
                    // Redireciona para a página de clientes após a notificação
                    window.location.href = "../../views/admin/listClientes.php";
                });
            
        </script>';
    } else {
        echo '
        <script>
            // Adicione um listener para o envio do formulário
           // Impede o envio padrão do formulário
    
                // Simula uma resposta bem-sucedida do servidor
                // Substitua isso pela lógica real do seu servidor
                Swal.fire({
                    icon: "error",
                    title: "Erro ao excluir cliente!",
                    showConfirmButton: false,
                    timer: 2500
                }).then(() => {
                    // Redireciona para a página de clientes após a notificação
                    window.location.href = "../../views/admin/listClientes.php";
                });
            
        </script>';
    }
} else {
    // Se 'id' não estiver presente na URL
    echo "Parâmetro 'id' não encontrado na URL.";
}
?>
