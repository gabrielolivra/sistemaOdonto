<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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

    // Conecta ao banco de dados (substitua com suas configurações)
    $conn = conectarAoBanco();

    // Verifica se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Verifica se o CPF já está cadastrado
    $stmtVerificaCPF = $conn->prepare("SELECT cpf FROM clientes WHERE cpf = ?");
    $stmtVerificaCPF->bind_param("s", $cpf);
    $stmtVerificaCPF->execute();
    $stmtVerificaCPF->store_result();

    if ($stmtVerificaCPF->num_rows > 0) {
        echo '
        <script>
            // Adicione um listener para o envio do formulário
           // Impede o envio padrão do formulário
    
                // Simula uma resposta bem-sucedida do servidor
                // Substitua isso pela lógica real do seu servidor
                Swal.fire({
                    icon: "error",
                    title: "Esse CPF já está cadastrado!",
                    showConfirmButton: false,
                    timer: 2500
                }).then(() => {
                    // Redireciona para a página de clientes após a notificação
                    window.location.href = "../../views/admin/cadastroClientes.php";
                });
            
        </script>';
    } else {
        // Prepara e executa a inserção no banco de dados
        $stmt = $conn->prepare("INSERT INTO clientes (nome_completo, cpf, telefone, endereco_cep, endereco_cidade, endereco_estado, endereco_rua) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $nome, $cpf, $telefone, $cep, $cidade, $estado, $endereco);

        if ($stmt->execute()) {
            echo '
        <script>
            // Adicione um listener para o envio do formulário
           // Impede o envio padrão do formulário
    
                // Simula uma resposta bem-sucedida do servidor
                // Substitua isso pela lógica real do seu servidor
                Swal.fire({
                    icon: "success",
                    title: "Cliente cadastrado com sucesso!",
                    showConfirmButton: false,
                    timer: 2500
                }).then(() => {
                    // Redireciona para a página de clientes após a notificação
                    window.location.href = "../../views/admin/clientes.php";
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
                        title: "Erro ao cadastrar o cliente!",
                        showConfirmButton: false,
                        timer: 2500
                    }).then(() => {
                        // Redireciona para a página de clientes após a notificação
                        window.location.href = "../../views/admin/cadastroClientes.php";
                    });
                
            </script>';
        }

        // Fecha a conexão com o banco de dados
        $stmt->close();
    }

    // Fecha a conexão com o banco de dados
    $stmtVerificaCPF->close();
    $conn->close();
} else {
    echo "Método inválido para acessar este script.";
}
?>

