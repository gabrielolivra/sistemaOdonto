<?php

function verificarUsuarioLogado() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["user_id"])) {
        header("Location: ../../views/public/login.php");
        exit;
    }
    $id_do_usuario = $_SESSION["user_id"];
    return $id_do_usuario;
}
?>

