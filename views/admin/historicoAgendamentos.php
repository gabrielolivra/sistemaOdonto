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
$registrosPorPagina =5; // Defina o número de registros por página
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $registrosPorPagina;

// Inicializando a variável de resultados
$resultadosAgendamentos = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idAgendamento = $_POST["id_agendamento"];
    $acao = isset($_POST["acao"]) ? $_POST["acao"] : null;
    // Atualizar o status do agendamento
    if ($acao !== null) {
        // Atualizar o status do agendamento
        $sqlAtualizarStatus = "UPDATE agendamentos SET status = '$acao' WHERE id = $idAgendamento";
        $conn->query($sqlAtualizarStatus);
    }
    else{
    // Verificar se a chave 'finalizar' está definida no array $_POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idAgendamento = $_POST["id_agendamento"];
    
        // Verificar se a chave 'acao' está definida no array $_POST
        $acao = isset($_POST["acao"]) ? $_POST["acao"] : null;
    
        // Atualizar o status do agendamento, se 'acao' não for nulo
        if ($acao !== null) {
            $sqlAtualizarStatus = "UPDATE agendamentos SET status = '$acao' WHERE id = $idAgendamento";
            $conn->query($sqlAtualizarStatus);
        } else {
            // Verificar se a chave 'finalizar' está definida no array $_POST
            if (isset($_POST["finalizar"])) {
                $acaoFinalizar = $_POST["finalizar"];
    
                // Verificar se o campo 'status' é nulo antes de atualizar 'finalizar'
                $sqlVerificarStatusNulo = "SELECT status FROM agendamentos WHERE id = $idAgendamento";
                $resultStatus = $conn->query($sqlVerificarStatusNulo);
    
                if ($resultStatus !== false && $resultStatus->num_rows > 0) {
                    $rowStatus = $resultStatus->fetch_assoc();
                    $statusAtual = $rowStatus["status"];
    
                    // Atualizar o campo 'finalizar' somente se o campo 'status' não for nulo
                    if ($statusAtual !== null) {
                        $sqlAtualizarStatusFinalizar = "UPDATE agendamentos SET finalizar = '$acaoFinalizar' WHERE id = $idAgendamento";
                        $conn->query($sqlAtualizarStatusFinalizar);
                    }
                }
            }
        }
    }
    }
}

// Configurar as variáveis de filtro de datas
$dataInicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
$dataFim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';

// Obter a data atual
$dataAtual = date('Y-m-d');

// Construir a parte da condição da consulta SQL para o filtro de datas
$condicaoData = '';
if (!empty($dataInicio) && !empty($dataFim)) {
    $condicaoData = " AND ag.data_agendamento BETWEEN '$dataInicio' AND '$dataFim'";
} elseif (!empty($dataInicio)) {
    $condicaoData = " AND ag.data_agendamento >= '$dataInicio'";
} elseif (!empty($dataFim)) {
    $condicaoData = " AND ag.data_agendamento <= '$dataFim'";
}

// Query SQL para contar o número total de agendamentos com o filtro de datas
$sqlTotalAgendamentos = "SELECT COUNT(*) AS total FROM agendamentos ag INNER JOIN clientes cli ON cli.id = ag.cliente_id WHERE 1 $condicaoData and finalizar is not null";
$resultTotalAgendamentos = $conn->query($sqlTotalAgendamentos);
$totalAgendamentos = $resultTotalAgendamentos->fetch_assoc()['total'];

$sqlSomaValores = "SELECT SUM(ag.valor) AS valor_total FROM agendamentos ag WHERE 1 $condicaoData AND ag.finalizar IS NOT NULL and status ='confirmado'";
$resultSomaValores = $conn->query($sqlSomaValores);
$somaValores = $resultSomaValores->fetch_assoc()['valor_total'];
// Query SQL para selecionar agendamentos com limite, paginação e filtro de datas
$sqlAgendamentos = "SELECT ag.id as id, cli.nome_completo as cliente_id, cli.cpf as cpf, DATE_FORMAT(ag.data_agendamento, '%d/%m/%Y %H:%i') as data_agendamento, ag.valor, ag.tipo_procedimento, ag.observacoes, ag.status FROM agendamentos ag INNER JOIN clientes cli ON cli.id = ag.cliente_id WHERE finalizar is not null and 1 $condicaoData order by data_agendamento desc  LIMIT $registrosPorPagina OFFSET $offset";

// Executando a query
$resultAgendamentos = $conn->query($sqlAgendamentos);

// Verificando se há resultados
if ($resultAgendamentos !== false && $resultAgendamentos->num_rows > 0) {
    // Armazenando os resultados em um array
    while ($rowAgendamento = $resultAgendamentos->fetch_assoc()) {
        $resultadosAgendamentos[] = $rowAgendamento;
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
    <link rel="icon" href="../../assets/img/logo-sidebar.png" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/meusAgendamentos.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Agendamentos</title>
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
            <li><a href="../../assets/php/logout.php">Sair</a></li>
        </ul>
    </div>
</div>

    <div class="content">
        <h2>Historico de agendamentos</h2>
        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-filtro">
        <label for="data_inicio">Data de Início:</label>
        <input type="date" id="data_inicio" name="data_inicio">

        <label for="data_fim">Data de Fim:</label>
        <input type="date" id="data_fim" name="data_fim">

        <button type="submit">Filtrar</button>
    </form>
        <?php
        // Exibindo os resultados em uma tabela
        if (!empty($resultadosAgendamentos)) {
            echo "<p style='margin:10px 10px; font-weight:600;'>Valor recebido no periodo: ".$somaValores."</p>";
            echo "<table>";
            echo "<tr><th>Cliente</th><th>CPF</th><th>Data do Agendamento</th><th>Procedimento</th><th>Observações</th><th>Valor recebido</th><th>Status</th></tr>";

            foreach ($resultadosAgendamentos as $agendamento) {
                echo "<tr>";
                echo "<td>" . $agendamento["cliente_id"] . "</td>"; 
                echo "<td>" . $agendamento["cpf"] . "</td>";
                echo "<td>" . $agendamento["data_agendamento"] . "</td>";
                echo "<td>" . $agendamento["tipo_procedimento"] . "</td>";
                echo "<td>" . $agendamento["observacoes"] . "</td>";
                echo "<td>" . $agendamento["valor"] . "</td>";
                echo "<td>" . $agendamento["status"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";

            // Adiciona links de paginação
               // Adiciona links de paginação
               $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

               // Calcula o número total de páginas
               $totalPaginas = ceil($totalAgendamentos / $registrosPorPagina);
               
               // Adiciona links de páginação
               echo "<div class='pagination'>";
               
               // Link para a página anterior (desabilitado se estiver na primeira página)
               if ($paginaAtual > 1) {
                   echo "<a href='?pagina=".($paginaAtual - 1)."' class='paginacao'>Anterior</a> ";
               }
               
               // Adiciona links para páginas individuai
               
               // Link para a próxima página (desabilitado se estiver na última página)
               if ($paginaAtual < $totalPaginas) {
                   echo "<a href='?pagina=".($paginaAtual + 1)."' class='paginacao'>Próximo</a> ";
               }
               
               echo "</div>";
        } else {
            echo "Nenhum agendamento encontrado.";
        }
        ?>

    </div>
</div>

</body>
</html>
