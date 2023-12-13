<?php
session_start();
require 'conexao.php';
$conn = conectarAoBanco();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_imagem = $_POST['id_imagem'];
    $id_cliente = $_POST['id_cliente'];

    // Substitua 'galeria' pelo nome real da tabela no banco de dados
    $sql = "DELETE FROM galeria WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_imagem);

    if ($stmt->execute()) {
        // Redireciona de volta para a página de galeria
        header("Location: ../../views/admin/arquivoGaleria.php?id={$id_cliente}");
        exit();
    } else {
        echo "Erro ao excluir a imagem: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
