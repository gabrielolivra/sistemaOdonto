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


// Obtém a quantidade de clientes cadastrados
$sqlClientes = "SELECT COUNT(*) as totalClientes FROM clientes";
$resultClientes = $conn->query($sqlClientes);
$rowClientes = $resultClientes->fetch_assoc();
$totalClientes = $rowClientes['totalClientes'];
$dataFiltrada = isset($_GET['data']) ? $_GET['data'] : '';
// Obtém a quantidade de atendimentos realizados e recusados, e o valor total
$sqlAtendimentos = "SELECT 
                        COUNT(*) as totalAtendimentos,
                        SUM(CASE WHEN status = 'confirmado' THEN 1 ELSE 0 END) as totalRealizados,
                        SUM(CASE WHEN status = 'recusado' THEN 1 ELSE 0 END) as totalRecusados,
                        SUM(CASE WHEN status = 'confirmado' THEN valor ELSE 0 END) as valorRealizados,
                        SUM(CASE WHEN status = 'recusado' THEN valor ELSE 0 END) as valorRecusados
                    FROM agendamentos";
if (!empty($dataFiltrada)) {
    $sqlAtendimentos .= " WHERE DATE(data_agendamento) = '$dataFiltrada'";
}

$resultAtendimentos = $conn->query($sqlAtendimentos);
$rowAtendimentos = $resultAtendimentos->fetch_assoc();

$totalAtendimentos = $rowAtendimentos['totalAtendimentos'];
$totalRealizados = $rowAtendimentos['totalRealizados'];
$totalRecusados = $rowAtendimentos['totalRecusados'];
$valorRealizados = $rowAtendimentos['valorRealizados'];
$valorRecusados = $rowAtendimentos['valorRecusados'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="icon" href="../../assets/img/logo-sidebar.png" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/homeAdmin.css">
    <link rel="stylesheet" href="../../assets/css/prest-contas.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Contas a receber</title>
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
            <li><a href="../../views/admin/backup.php">Backup</a></li>
            <li><a href="../../assets/php/logout.php">Sair</a></li>
        </ul>
    </div>
</div>

    <div class="content">
    <h2>Prestação de contas</h2>

    <form method="get">
        <div class="datas">
    <label for="data">Filtrar por Data:</label>
    <input type="date" id="data" name="data" value="<?php echo $dataFiltrada; ?>"></div>
    <button type="submit">Filtrar</button>
</form>
<canvas id="atendimentosChart" width="600" height="100"></canvas>



<script>
    // Configuração do gráfico com Chart.js
    var ctx = document.getElementById('atendimentosChart').getContext('2d');
    var atendimentosChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Quantidade de agendamentos', 'Atendimentos realizados', 'Cliente não veio'],
            datasets: [{
                label: 'Agendamentos',
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56'],
                borderColor: '#333',
                borderWidth: 1,
                data: [<?php echo $totalAtendimentos; ?>, <?php echo $totalRealizados; ?>, <?php echo $totalRecusados; ?>]
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<div class="container-dados">
<div class="container-sum-dados dados-confirmados">
<p>Atendimentos realizados</br> <span>R$ <?php echo $valorRealizados; ?></span></p></div>
<div class="container-sum-dados dados-recusados">
<p>Cliente cancelou</br><span> R$ <?php echo $valorRecusados; ?></span></p></div></div>

</div>
</body>
</html>
