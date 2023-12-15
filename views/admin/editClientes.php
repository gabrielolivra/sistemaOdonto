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


if (isset($_GET['id'])) {
    // Obtém o ID passado por parâmetro na URL
    $cliente_id = $_GET['id'];

    // Prepara a consulta SQL usando uma instrução preparada
    $sql = "SELECT * FROM clientes WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Vincula o parâmetro
    $stmt->bind_param("i", $cliente_id);

    // Executa a consulta
    if ($stmt->execute()) {
        // Obtém o resultado
        $result = $stmt->get_result();

        // Verifica se há resultados
        if ($result->num_rows > 0) {
            // Obtém os dados do cliente
            $row = $result->fetch_assoc();

            // Preenche os valores nos campos do formulário
            $nome_completo = htmlspecialchars($row["nome_completo"]);
            $cpf = htmlspecialchars($row["cpf"]); // Não temos o CPF na consulta, você deve adicionar caso seja necessário
            $telefone = htmlspecialchars($row["telefone"]);// Não temos o telefone na consulta, você deve adicionar caso seja necessário
            $cep = htmlspecialchars($row["endereco_cep"]);// Não temos o CEP na consulta, você deve adicionar caso seja necessário
            $cidade = htmlspecialchars($row["endereco_cidade"]); 
            $estado = htmlspecialchars($row["endereco_estado"]); // Não temos o estado na consulta, você deve adicionar caso seja necessário
            $endereco = htmlspecialchars($row["endereco_rua"]);; // Não temos o endereço na consulta, você deve adicionar caso seja necessário
        } else {
            echo "Nenhum cliente encontrado com o ID fornecido.";
            // Você pode redirecionar ou tomar outras ações aqui, se necessário
        }
    } else {
        echo "Erro na execução da consulta: " . $stmt->error;
        // Você pode redirecionar ou tomar outras ações aqui, se necessário
    }

    // Fecha a instrução preparada
    $stmt->close();
} else {
    echo "O parâmetro 'id' não foi fornecido na URL.";
    // Você pode redirecionar ou tomar outras ações aqui, se necessário
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/cadastroClientes.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <script src="../../assets/js/functions.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="icon" href="../../assets/img/logo-sidebar.png" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Editar clientes</title>
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
        <h2>Atualizar dados do clientes</h2>

<!-- Formulário HTML com os campos preenchidos -->
<form action="../../assets/php/atualiza_cadastro_cliente.php" method="POST" id="cadastroForm">
    <label for="nome">Nome Completo</label>
    <input type="text" id="nome" name="nome" required placeholder="Digite o nome do cliente" value="<?php echo $nome_completo; ?>">

    <label for="cpf">CPF</label>
    <input type="text" id="cpf" name="cpf"  placeholder="Digite o cpf do cliente" value="<?php echo $cpf; ?>">

    <label for="telefone">Telefone</label>
    <input type="text" id="telefone" name="telefone" required placeholder="Digite o telefone do cliente" value="<?php echo $telefone; ?>">

    <label for="cep">CEP</label>
    <input type="text" id="cep" name="cep"  onblur="buscarCEP()" placeholder="Digite o CEP do cliente" value="<?php echo $cep; ?>">

    <label for="cidade">Cidade</label>
    <input type="text" id="cidade" name="cidade"  placeholder="Digite a cidade do cliente" value="<?php echo $cidade; ?>">

    <label for="estado">Estado</label>
    <input type="text" id="estado" name="estado"  placeholder="Digite o estado do cliente" value="<?php echo $estado; ?>">

    <label for="endereco">Endereço</label>
    <input type="text" id="endereco" name="endereco" placeholder="Digite o endereço do cliente" value="<?php echo $endereco; ?>">

    <input type="hidden" name="id_cliente" value="<?php echo $cliente_id?>">

    <a href="../../views/admin/listClientes.php"><button type="button" style="background:red">Voltar</button></a>
    <button type="submit">Atualizar cliente</button>
</form>

    </div>
</div>

</body>
</html>

<script>
    $(document).ready(function () {
    // Aplica a máscara ao campo de CEP
    $('#cep').inputmask('99999-999');
    $('#cpf').inputmask('999.999.999-99');
    $('#telefone').inputmask('(99) 99999-9999');
});
$('#nome').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
        $('#endereco').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
        $('#cidade').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
        $('#estado').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
</script>