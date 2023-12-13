<?php
session_start();
require '../../assets/php/conexao.php';
$conn = conectarAoBanco();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    echo $email;
    echo $senha;

    $sql = "SELECT id, senha, is_admin FROM cadastro_user WHERE email = ?";
    
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $_SESSION['erro'] = "Falha na preparação da declaração: " . $conn->error;
        header("Location: ./login.php");
        exit();
    }

    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($senha, $row['senha'])) {
                $_SESSION['user_id'] = $row['id'];

                if ($row['is_admin']) {
                    header("Location: ../../views/admin/home.php");
                    exit();
                } else {
                    header("Location: ../../views/autenticado/home.php");
                    exit();
                }
            } else {
                $_SESSION['erro'] = "Senha incorreta!";
                header("Location:../../index.php");
                exit();
            }
        } else {
            $_SESSION['erro'] = "Usuário não encontrado!";
            header("Location:../../views/public/login.php");
            exit();
        }
    } else {
        $_SESSION['erro'] = "Erro ao buscar no banco de dados: " . $stmt->error;
        header("Location:../../views/public/login.php");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>