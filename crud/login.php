<?php
session_start();
require_once('../class/functions.php');
require_once('../crud/email_functions.php');


define('MAX_FAILED_ATTEMPTS', 3);

define('ATTEMPT_WINDOW', 900); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    if (!isset($_COOKIE['failed_attempts_' . $username])) {
        setcookie('failed_attempts_' . $username, 0, time() + ATTEMPT_WINDOW, "/");
        setcookie('first_attempt_time_' . $username, time(), time() + ATTEMPT_WINDOW, "/");
        $_COOKIE['failed_attempts_' . $username] = 0;
        $_COOKIE['first_attempt_time_' . $username] = time();
    }
    $failed_attempts = (int)$_COOKIE['failed_attempts_' . $username];
    $first_attempt_time = (int)$_COOKIE['first_attempt_time_' . $username];

    if ($failed_attempts >= MAX_FAILED_ATTEMPTS) {
        $time_since_first_attempt = time() - $first_attempt_time;

        if ($time_since_first_attempt < ATTEMPT_WINDOW) {
            header("Location: ../index.php?error=limite_superado"); 
            exit();
        } else {
            setcookie('failed_attempts_' . $username, 0, time() + ATTEMPT_WINDOW, "/");
            setcookie('first_attempt_time_' . $username, time(), time() + ATTEMPT_WINDOW, "/");
            $failed_attempts = 0;
            $first_attempt_time = time();
        }
    }

    $obj_funciones = new funciones();
    $login_success = $obj_funciones->verificar_login($username, $password);

    if ($login_success) {

        setcookie('failed_attempts_' . $username, 0, time() + ATTEMPT_WINDOW, "/");

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

        $failed_attempts++;
        setcookie('failed_attempts_' . $username, $failed_attempts, time() + ATTEMPT_WINDOW, "/");
        if ($failed_attempts == 1) {
            setcookie('first_attempt_time_' . $username, time(), time() + ATTEMPT_WINDOW, "/");
        }

        header("Location: ../index.php?error=1");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
