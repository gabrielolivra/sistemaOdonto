<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Galeria</title>
</head>
<body>
    
</body>
</html>
<?php
session_start();

require '../../assets/php/conexao.php';
require '../../assets/php/idUserLogado.php';

$conn = conectarAoBanco();
$user = verificarUsuarioLogado();

// Função para validar e cadastrar os dados do pet
function anexarGaleria($id_usuario, $descricao, $imagem)
{
    $conn = conectarAoBanco();

    $sql = "INSERT INTO galeria (usuario_id, descricao, imagem) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Falha na preparação da declaração: " . $conn->error);
    }

    $stmt->bind_param("iss", $id_usuario, $descricao, $imagem);

    if ($stmt->execute()) {
        echo '
        <script>
            // Adicione um listener para o envio do formulário
           // Impede o envio padrão do formulário
    
                // Simula uma resposta bem-sucedida do servidor
                // Substitua isso pela lógica real do seu servidor
                Swal.fire({
                    icon: "success",
                    title: "Imagem adicionada a galeria com sucesso!",
                    showConfirmButton: false,
                    timer: 2500
                }).then(() => {
                    // Redireciona para a página de clientes após a notificação
                    window.location.href = "../../views/admin/arquivoGaleria.php?id='.$id_usuario.'";
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
                        title: "Erro ao salvar imagem na galeria!",
                        showConfirmButton: false,
                        timer: 2500
                    }).then(() => {
                        // Redireciona para a página de clientes após a notificação
                        window.location.href = "../../views/admin/arquivoGaleria.php?id='.$id_usuario.'";
                    });
                
            </script>';
    }

    $stmt->close();
    $conn->close();
}

// Processa o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_cliente'];
    $descricao = $_POST['descricao'];

    // Verifica se foi enviado um arquivo
    if (isset($_FILES['imagem'])) {
        $imagem = salvarImagem($_FILES['imagem']);
        if ($imagem !== null) {
            anexarGaleria($id_usuario, $descricao, $imagem);
        }
    } else {
        // Lidar com o caso em que não foi enviado um arquivo
        echo "Erro: Nenhuma imagem enviada.";
    }
}

// Função para processar o upload de imagens
function salvarImagem($imagem)
{
    $uploadDir = '../../assets/galeria/';
    $uploadFile = $uploadDir . basename($imagem['name']);

    if (move_uploaded_file($imagem['tmp_name'], $uploadFile)) {
        // A imagem foi carregada com sucesso, você pode salvar o caminho no banco de dados
        return $uploadFile;
    } else {
        echo 'Erro ao carregar a imagem.';
        return null;
    }
}
?>
