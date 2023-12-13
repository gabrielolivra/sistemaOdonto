<?php
 require '../../assets/php/conexao.php';
function verificarUsuarioLogado() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["user_id"])) {
        header("Location: ../../views/public/login.php");
        exit;
    }

    $id_do_usuario = $_SESSION["user_id"];

    // Consultar o banco de dados para obter informações adicionais do usuário, incluindo is_admin
   
    $conn = conectarAoBanco();

    $sql = "SELECT id, is_admin FROM cadastro_user WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Falha na preparação da declaração: " . $conn->error);
    }

    $stmt->bind_param("i", $id_do_usuario);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $stmt->close();
            $conn->close();
            
            return $user;
        } else {
            // Caso o usuário não seja encontrado, redirecione para a página de login
            header("Location: ../../views/public/login.php");
            exit;
        }
    } else {
        echo "Erro ao buscar no banco de dados: " . $stmt->error;
        exit;
    }
}
?>