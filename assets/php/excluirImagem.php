<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria</title>
</head>
<body>
</body>
</html>
<?php
session_start();
require '../../assets/php/conexao.php';
$conn = conectarAoBanco();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_imagem = $_POST['id_imagem'];
    $id_cliente = $_POST['id_cliente'];

    // Obtenha o caminho do arquivo da imagem
    $sql_select = "SELECT imagem FROM galeria WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id_imagem);
    $stmt_select->execute();
    $stmt_select->bind_result($caminho_imagem);

    if ($stmt_select->fetch()) {
        // Exclua a imagem do banco de dados
        $stmt_select->close();

        $sql_delete = "DELETE FROM galeria WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id_imagem);

        if ($stmt_delete->execute()) {
            // Exclua o arquivo da imagem
            if (unlink($caminho_imagem)) {
                header("Location: ../../views/admin/arquivoGaleria.php?id={$id_cliente}");
                exit();
            } else {
                echo "Erro ao excluir o arquivo da imagem.";
            }
        } else {
            echo "Erro ao excluir a imagem: " . $stmt_delete->error;
        }

        $stmt_delete->close();
    } else {
        echo "Imagem não encontrada.";
    }

    $conn->close();
}
?>
