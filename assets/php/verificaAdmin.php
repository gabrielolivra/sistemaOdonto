<?php
require '../../assets/php/usuarioLogado.php';
// Função para verificar se o usuário é um administrador
function isAdmin() {
    // Suponhamos que você tenha uma função verificarUsuarioLogado() que retorna os detalhes do usuário
    $user = verificarUsuarioLogado();

    // Verifique se o usuário é um administrador (altere conforme necessário)
    return isset($user['is_admin']) && $user['is_admin'] == 1;
}
?>