<?php
session_start();
require_once('../class/functions.php');
require_once('../crud/email_functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $obj_funciones = new funciones();
    $login_success = $obj_funciones->verificar_login($username, $password);

    if ($login_success) {
        $verification_code = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+{}[]|\/?><'), 0, 6);

        $_SESSION['verification_code'] = $verification_code;
        $_SESSION['username'] = $username;
        $user_email = $username;
        if (sendVerificationCode($user_email, $verification_code)) {
            header("Location: ../verificar_codigo.php");
            exit();
        } else {
            header("Location: ../index.php?error=2");
            exit();
        }
    } else {
        header("Location: ../index.php?error=1");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
