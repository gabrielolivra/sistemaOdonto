<?php 
require '../../assets/php/conexao.php';
// Conecta ao banco de dados (substitua com suas configurações)


function dashboardHome(){
    $conn = conectarAoBanco();
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }
    
    // Busca a quantidade de clientes
    $resultClientes = $conn->query("SELECT COUNT(*) AS totalClientes FROM clientes");
    $rowClientes = $resultClientes->fetch_assoc();
    $GLOBALS['totalClientes'] = $rowClientes['totalClientes'];
    
    // Busca a quantidade de agendamentos filtrados por data (exemplo: data atual)
    // Obtém o dia, mês e ano atual
    $diaAtual = date('d');
    $mesAtual = date('m');
    $anoAtual = date('Y');
    
    // Monta a data no formato YYYY-MM-DD
    $dataAtualFormatada = "$anoAtual-$mesAtual-$diaAtual";
    
    // Executa a consulta SQL
    $resultAgendamentos = $conn->query("SELECT COUNT(*) AS totalAgendamentos FROM agendamentos WHERE DATE(data_agendamento) = '$dataAtualFormatada' and finalizar is null");
    
    // Verifica se a consulta foi bem-sucedida
    if ($resultAgendamentos !== false) {
        // Obtém o resultado da consulta
        $rowAgendamentos = $resultAgendamentos->fetch_assoc();
    
        // Armazena o total de agendamentos em uma variável global
        $GLOBALS['totalAgendamentos'] = $rowAgendamentos['totalAgendamentos'];
    
    // Fecha a conexão com o banco de dados
    $conn->close();
}
}

?>


<?php

function agendar($cliente, $dataAgendamento, $tipoProcedimento, $observacoes,$valor ) {
    // Conectar ao banco de dados (substitua com suas configurações)
    $conn = conectarAoBanco();

    // Verificar se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Verificar se o horário já está agendado
    if (horarioJaAgendado($conn, $dataAgendamento)) {
        // Se o horário já estiver agendado, exibe um popup
        echo '<script>
                alert("Já possui um cliente agendado para esse horario! Selecione outro!")
                window.location.href = "../../views/admin/agendamentos.php?id='.$cliente.'";
              </script>';
              
    } else {
        // Preparar a declaração SQL para a inserção do agendamento
        $stmt = $conn->prepare("INSERT INTO agendamentos (cliente_id, data_agendamento, tipo_procedimento, observacoes, valor) VALUES (?, ?, ?, ?, ?)");

        // Verificar se a preparação foi bem-sucedida
        if ($stmt === false) {
            die("Erro na preparação da declaração SQL: " . $conn->error);
        }

        // Bind dos parâmetros
        $stmt->bind_param("sssss", $cliente, $dataAgendamento, $tipoProcedimento, $observacoes, $valor);

        // Executar a declaração
        $result = $stmt->execute();

        // Verificar se a execução foi bem-sucedida
        if ($result === false) {
            die("Erro na execução da declaração SQL: " . $stmt->error);
        }

        // Fechar a declaração e a conexão com o banco de dados
        $stmt->close();
        $conn->close();
    }
}

// Função para verificar se o horário já está agendado
function horarioJaAgendado($conn, $dataAgendamento) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS totalAgendamentos FROM agendamentos WHERE data_agendamento = ?");
    $stmt->bind_param("s", $dataAgendamento);
    $stmt->execute();
    $stmt->bind_result($totalAgendamentos);
    $stmt->fetch();
    $stmt->close();

    // Se existir algum agendamento para o mesmo horário, retorna verdadeiro
    return $totalAgendamentos > 0;
}


?>
