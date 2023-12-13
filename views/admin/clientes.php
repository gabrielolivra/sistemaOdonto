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

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Inicializando a variável de resultados
$resultados = array();
$result = null;  // Inicializa a variável $result

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter o nome digitado no formulário
    $nome = $_POST["nome_cliente"];

    // Verifica se um nome foi fornecido para a busca
    if (!empty($nome)) {
        // Query SQL para selecionar clientes pelo nome
        $sql = "SELECT * FROM clientes WHERE nome_completo LIKE '%$nome%'";
    } else {
        // Se nenhum nome foi fornecido, selecionar todos os clientes
        $sql = "SELECT * FROM clientes";
    }

    // Executando a query
    $result = $conn->query($sql);

    // Verificando se há resultados
    if ($result !== false && $result->num_rows > 0) {
        // Armazenando os resultados em um array
        while($row = $result->fetch_assoc()) {
            $resultados[] = $row;
        }
    }
    
}
else{
    $sql = "SELECT * FROM clientes";
    $result = $conn->query($sql);

    // Verificando se há resultados
    if ($result !== false && $result->num_rows > 0) {
        // Armazenando os resultados em um array
        while($row = $result->fetch_assoc()) {
            $resultados[] = $row;
        }
    }
}

// Fechando a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/clientes.css">
    <link rel="stylesheet" href="../../assets/css/homeAdmin.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Clientes</title>
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
        </ul>
    </div>

    <div class="content">
    <h2>Clientes</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="text" name="nome_cliente">
    <input type="submit" value="Buscar">
</form>
<?php
// Exibindo os resultados em uma tabela
if (!empty($resultados)) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Nome</th><th>CPF</th><th>Agendar</th></tr>";
    
    foreach ($resultados as $cliente) {
        echo "<tr>";
        echo "<td>" . $cliente["id"] . "</td>";
        echo "<td>" . $cliente["nome_completo"] . "</td>";
        echo "<td>" . $cliente["cpf"] . "</td>";
        echo "<td><button class='agendar' data-id='" . $cliente["id"] . "'>Agendar</button></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Nenhum resultado encontrado";
    echo "SQL: " . $result;

}
?>


    </div>
    </div>
</body>
</html>
<script>
    $(document).ready(function () {
        // Adiciona um evento de clique nos botões "Agendar"
        $(".agendar").on("click", function () {
            // Obtém o ID do cliente associado ao botão clicado
            var clienteId = $(this).data("id");
            window.location.href = "agendamentos.php?id=" + clienteId;
        });
    });
</script>