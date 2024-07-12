<?php
session_start();
require_once('../class/functions.php');
require_once('../crud/email_functions.php');

$logFile = '../class/login_logs.log';

define('MAX_FAILED_ATTEMPTS', 3);
define('ATTEMPT_WINDOW', 900); 
$cookie_expiration = time() + ATTEMPT_WINDOW;
$obj_funciones = new funciones();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $client_ip = $_SERVER['REMOTE_ADDR'];

    if (!isset($_COOKIE['failed_attempts_' . $username])) {
        setcookie('failed_attempts_' . $username, $failed_attempts, $cookie_expiration, "/");
setcookie('first_attempt_time_' . $username, $first_attempt_time, $cookie_expiration, "/");
    }

    $failed_attempts = (int)$_COOKIE['failed_attempts_' . $username];
    $first_attempt_time = (int)$_COOKIE['first_attempt_time_' . $username];

    if ($failed_attempts >= MAX_FAILED_ATTEMPTS) {
        $time_since_first_attempt = time() - $first_attempt_time;

        if ($time_since_first_attempt < ATTEMPT_WINDOW) {
            logAttempt($logFile, $username, $client_ip, "Intento fallido - Límite de intentos superado");
            header("Location: ../index.php?error=limite_superado");
            exit();
        } else {
            setcookie('failed_attempts_' . $username, 0, time() + ATTEMPT_WINDOW, "/");
            setcookie('first_attempt_time_' . $username, time(), time() + ATTEMPT_WINDOW, "/");
            $failed_attempts = 0;
            $first_attempt_time = time();
        }
    }

    $login_success = $obj_funciones->verificar_login($username, $password);

    if ($login_success) {
        setcookie('failed_attempts_' . $username, 0, time() + ATTEMPT_WINDOW, "/");
        logAttempt($logFile, $username, $client_ip, "Inicio de sesión exitoso");

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

        logAttempt($logFile, $username, $client_ip, "Intento fallido - Credenciales incorrectas");
        header("Location: ../index.php?error=1"); 
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}

function logAttempt($logFile, $username, $client_ip, $message) {
    $logData = "[" . date('Y-m-d H:i:s') . "] IP: {$client_ip} - Username: {$username} - {$message}" . PHP_EOL;
    file_put_contents($logFile, $logData, FILE_APPEND);
}
?>
