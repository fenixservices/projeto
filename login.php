<?php
session_start();
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $query = "SELECT * FROM usuario WHERE usuario = '$login' AND senha = '$senha'";
    $result = mysqli_query($conexao, $query);

    if (mysqli_num_rows($result) == 1) {
        $login = mysqli_fetch_assoc($result);
        $_SESSION['usuario_id'] = $login['id'];
        $_SESSION['usuario_nome'] = $login['nome'];
        $_SESSION['nivel_acesso'] = $login['nivel_acesso'];

        header('Location: dashboard.php');
        exit();
    } else {
        echo "<h1>Login falhou. Verifique suas credenciais.</h1>";
    }
}
?>

<style>

    h1{
        font-size: 20px;
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        background-color: black;
        color: white;
        padding: 10px;
        margin-top: 20px;
    }
    </style>