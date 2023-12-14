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

// Função para listar imagens do usuário
function listarImagensUsuario($usuario_id) {
    $conn = conectarAoBanco();

    // Substitua 'galeria' pelo nome real da tabela no banco de dados
    $sql = "SELECT id, usuario_id, descricao, imagem FROM galeria WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $imagens = array();

    while ($row = $result->fetch_assoc()) {
        $imagens[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $imagens;
}

// Processa o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (seu código para processar o formulário e salvar a nova imagem)

    // Redireciona para evitar o reenvio do formulário ao recarregar a página
    header("Location: {$_SERVER['PHP_SELF']}?id={$_GET['id']}");
    exit();
}

// Verifica se foi passado um valor 'id' na URL
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Chama a função para listar as imagens do usuário
    $imagensUsuario = listarImagensUsuario($id_usuario);
} else {
    // Caso 'id' não seja fornecido, você pode tratar isso de acordo com a sua lógica
    echo "Erro: Parâmetro 'id' não fornecido na URL.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/arquivoGaleria.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Galeria</title>
</head>
<body>
    <div class="container">
    <div class="test">
    <div class="sidebar">
        <img src="../../assets/img/logo-sidebar.png" alt="">
        <ul>
        <li><a href="../../views/admin/home.php">Página Inicial</a></li>
            <li><a href="../../views/admin/cadastroClientes.php">Cadastro de clientes</a></li>
            <li><a href="../../views/admin/clientes.php">Agendar</a></li>
            <li><a href="../../views/admin/listAgendamentos.php">Agendamentos</a></li>            
            <li><a href="../../views/admin/galeria.php">Galeria de clientes</a></li>
            <li><a href="../../views/admin/historicoAgendamentos.php">Histórico de Agendamentos</a></li>
            <li><a href="../../assets/php/logout.php">Sair</a></li>
        </ul>
    </div>
</div>

        <div class="content">
            <h2>Galeria</h2>

            <form action="../../assets/php/cadastroGaleria.php?id=<?php echo htmlspecialchars($_GET['id']); ?>" method="post" enctype="multipart/form-data" class="add-img-form">
            <div class="container-dados">
                <label for="descricao">Descrição</label>
                <input type="text" name="descricao" required placeholder ="Digite a descrição do item"></div>
                <div class="container-dados">
    <label for="imagem" id="imagemLabel" class="custom-file-upload">
        Clique aqui para adicionar uma imagem
    </label>
    <input type="file" name="imagem" id="imagem" class="input-file" onchange="atualizarLabel()" required >
</div>
                <input type="hidden" name="id_cliente" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                <input type="submit" value="Adicionar Imagem" class="add-img">
            </form>
            <?php foreach ($imagensUsuario as $imagem) : ?>
    <section>
    <div class="container-dados-enviados">
        
        <img src="<?php echo $imagem['imagem']; ?>" alt="Imagem do Usuário">
        <p>Descrição: <?php echo $imagem['descricao']; ?></p>
        <div class="btns-container-dados-enviados">
        <button onclick="abrirModal('<?php echo $imagem['imagem']; ?>')">Abrir</button>
        <form id="excluirForm" action="../../assets/php/excluirImagem.php" method="post">
    <input type="hidden" name="id_imagem" value="<?php echo $imagem['id']; ?>">
    <input type="hidden" name="id_cliente" value="<?php echo htmlspecialchars($_GET['id']); ?>">
    <input type="button" value="Excluir" onclick="confirmarExclusao()">
</form>
        </div>
    </div>
<?php endforeach; ?>
</section>
<div id="imagemModal" class="modal">
    <span class="fechar" onclick="fecharModal()">&times;</span>
    <img class="modal-content" id="imagemModalContent">
</div>
</div>
</div>
</body>
</html>
<script>
    function abrirModal(caminhoImagem) {
        var modal = document.getElementById('imagemModal');
        var imagemModalContent = document.getElementById('imagemModalContent');

        imagemModalContent.src = caminhoImagem;
        modal.style.display = 'block';
    }

    function fecharModal() {
        var modal = document.getElementById('imagemModal');
        modal.style.display = 'none';
    }

    function confirmarExclusao() {
        var confirmacao = confirm("Tem certeza de que deseja excluir?");
        if (confirmacao) {
            document.getElementById("excluirForm").submit();
        }
    }
    

    function atualizarLabel() {
        var input = document.getElementById('imagem');
        var label = document.getElementById('imagemLabel');

        if (input.files.length > 0) {
            label.innerText = input.files[0].name;
        } else {
            label.innerText = 'Clique aqui para adicionar uma imagem';
        }
    }

</script>
