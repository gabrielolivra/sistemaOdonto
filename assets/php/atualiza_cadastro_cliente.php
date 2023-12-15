<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Atualizar cliente</title>
</head>
<body>
    
</body>
</html>

<?php
require '../../assets/php/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $cep = $_POST["cep"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estado"];
    $endereco = $_POST["endereco"];
    $id_cliente = $_POST["id_cliente"];

    // Conecta ao banco de dados (substitua com suas configurações)
    $conn = conectarAoBanco();


    // Prepara a consulta SQL para atualizar os dados do cliente
    $sql = "UPDATE clientes SET nome_completo=?, cpf=?, telefone=?, endereco_cep=?, endereco_cidade=?, endereco_estado=?, endereco_rua=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    
    // Vincula os parâmetros
    $stmt->bind_param("sssssssi", $nome, $cpf, $telefone, $cep, $cidade, $estado, $endereco, $id_cliente);


    // Executa a atualização
    if ($stmt->execute()) {
        echo '
        <script>
            // Adicione um listener para o envio do formulário
           // Impede o envio padrão do formulário
    
                // Simula uma resposta bem-sucedida do servidor
                // Substitua isso pela lógica real do seu servidor
                Swal.fire({
                    icon: "success",
                    title: "Cliente atualizado com sucesso!",
                    showConfirmButton: false,
                    timer: 2500
                }).then(() => {
                    // Redireciona para a página de clientes após a notificação
                    window.location.href = "../../views/admin/listClientes.php";
                });
            
        </script>';
        // Você pode redirecionar ou tomar outras ações aqui, se necessário
    } else {
        echo '
        <script>
            // Adicione um listener para o envio do formulário
           // Impede o envio padrão do formulário
    
                // Simula uma resposta bem-sucedida do servidor
                // Substitua isso pela lógica real do seu servidor
                Swal.fire({
                    icon: "error",
                    title: "Erro ao atualizar o cliente!",
                    showConfirmButton: false,
                    timer: 2500
                }).then(() => {
                    // Redireciona para a página de clientes após a notificação
                    window.location.href = "../../views/admin/listClientes.php";
                });
            
        </script>';
        // Você pode redirecionar ou tomar outras ações aqui, se necessário
    }

    // Fecha a instrução preparada
    $stmt->close();
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

  