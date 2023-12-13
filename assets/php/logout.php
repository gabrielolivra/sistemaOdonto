<?php
// Inicia a sessão
session_start();

// Destrói todas as variáveis de sessão
session_destroy();

// Redireciona o usuário para a página de login ou outra página desejada
header("Location: ../../index.php");
exit;
?>