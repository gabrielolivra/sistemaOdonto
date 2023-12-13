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

    // Realize as validações necessárias aqui...

    // Conecta ao banco de dados (substitua com suas configurações)
    $conn = conectarAoBanco();

    // Verifica se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Prepara e executa a inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO clientes (nome_completo,cpf, telefone, endereco_cep, endereco_cidade, endereco_estado, endereco_rua) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nome, $cpf, $telefone, $cep, $cidade, $estado, $endereco);

    if ($stmt->execute()) {
        echo "Cliente cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o cliente: " . $stmt->error;
    }

    // Fecha a conexão com o banco de dados
    $stmt->close();
    $conn->close();
} else {
    echo "Método inválido para acessar este script.";
}

?>
