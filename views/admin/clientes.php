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

// Inicializando variáveis de paginação
$registrosPorPagina = 8; // Defina o número de registros por página
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $registrosPorPagina;
 
$sqlTotalAgendamentos = "SELECT COUNT(*) as total from clientes";
$resultTotalAgendamentos = $conn->query($sqlTotalAgendamentos);
$totalClientes = $resultTotalAgendamentos->fetch_assoc()['total'];
// Inicializando a variável de resultados
$resultadosClientes = array();

// Verificação se o formulário de busca foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter o nome digitado no formulário
    $nome = $_POST["nome_cliente"];

    // Verifica se um nome foi fornecido para a busca
    if (!empty($nome)) {
        // Query SQL para selecionar clientes pelo nome
        $sqlClientes = "SELECT * FROM clientes WHERE nome_completo LIKE '%$nome%' LIMIT $registrosPorPagina OFFSET $offset";
    } else {
        // Se nenhum nome foi fornecido, selecionar todos os clientes
        $sqlClientes = "SELECT * FROM clientes LIMIT $registrosPorPagina OFFSET $offset";
    }
} else {
    // Query SQL para selecionar clientes com limite, paginação (sem filtro de busca)
    $sqlClientes = "SELECT * FROM clientes LIMIT $registrosPorPagina OFFSET $offset";
}

// Executando a query
$resultClientes = $conn->query($sqlClientes);

// Verificando se há resultados
if ($resultClientes !== false && $resultClientes->num_rows > 0) {
    // Armazenando os resultados em um array
    while ($rowClientes = $resultClientes->fetch_assoc()) {
        $resultadosClientes[] = $rowClientes;
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
    <link rel="icon" href="../../assets/img/logo-sidebar.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Agendar clientes</title>
</head>
<body>

<div class="container">
<div class="test">
    <div class="sidebar">
        <img src="../../assets/img/logo-sidebar.png" alt="">
        <ul>
        <li><a href="../../views/admin/home.php">Página Inicial</a></li>
            <li><a href="../../views/admin/cadastroClientes.php">Cadastro de clientes</a></li>
            <li><a href="../../views/admin/listClientes.php">Meus clientes</a></li>
            <li><a href="../../views/admin/clientes.php">Agendar</a></li>
            <li><a href="../../views/admin/listAgendamentos.php">Agendamentos</a></li>            
            <li><a href="../../views/admin/galeria.php">Galeria de clientes</a></li>
            <li><a href="../../views/admin/historicoAgendamentos.php">Histórico de Agendamentos</a></li>
            <li><a href="../../views/admin/saldo.php">Prestação de contas</a></li>
            <li><a href="../../assets/php/logout.php">Sair</a></li>
        </ul>
    </div>
</div>


    <div class="content">
        <h2>Agendar clientes</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" name="nome_cliente" placeholder="Digite o nome do cliente">
            <input type="submit" value="Buscar">
        </form>
        <?php
        // Exibindo os resultados em uma tabela
        if (!empty($resultadosClientes)) {
            echo "<table>";
            echo "<tr><th>Cliente</th><th>CPF</th><th>Telefone</th><th>Cidade</th><th>Endereço</th><th>Agendar</th></tr>";

            foreach ($resultadosClientes as $cliente) {
                echo "<tr>";
                echo "<td>" . $cliente["nome_completo"] . "</td>"; 
                echo "<td>" . $cliente["cpf"] . "</td>";
                echo "<td>" . $cliente["telefone"] . "</td>";
                echo "<td>" . $cliente["endereco_cidade"] . "</td>";
                echo "<td>" . $cliente["endereco_rua"] . "</td>";
                echo "<td><button class='agendar' data-id='" . $cliente["id"] . "'>Agendar</button></td>";
                echo "</tr>";
            }

            echo "</table>";

            // Adiciona links de paginação
            $totalPaginas = ceil($totalClientes/ $registrosPorPagina);
            echo "<div class='pagination'>";
            for ($i = 1; $i <= $totalPaginas; $i++) {
                echo "<a href='?pagina=$i' class='paginacao'>$i</a> ";
            }
            echo "</div>";
        } else {
            echo "Nenhum cliente encontrado.";
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
