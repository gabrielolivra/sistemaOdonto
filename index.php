<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <form action="assets/php/validaLogin.php" method="post">
        <img src="assets/img/logo.jpg" alt="">
<div class="input-data">
         <label for="email">Usuario</label>
         <input type="text" placeholder="Digite seu e-mail" name="email">
        </div>
        <div class="input-data">
         <label for="senha">Senha</label>
         <input type="password" placeholder="Digite sua senha" name="senha">
        </div>
        <input type="submit" value="Entrar" class="btn-entrar" onclick="login()">
        <?php
        session_start();

        if (isset($_SESSION['erro'])) {
            echo '<div class="mensagem-erro">' . $_SESSION['erro'] . '</div>';
            unset($_SESSION['erro']);
        }
        ?>
        </form>
</body>
</html>