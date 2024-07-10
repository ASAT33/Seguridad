<?php
require_once('../class/functions.php');

function sendVerificationCode($to_email, $verification_code) {
    $apiKey = '';
    $senderEmail = 'prestamos@gmail.com';
    $senderName = 'Prestamos';
    $subject = 'Tu código de verificación';
    $htmlContent = '
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 20px auto;
                padding: 20px;
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #333;
                text-align: center;
            }
            .note {
                text-align: center;
                margin-top: 20px;
                color: #999;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Tu código de verificación es: ' . $verification_code . '</h1>
            <p class="note">Si no fuiste tú, ignora este mensaje.</p>
        </div>
    </body>
    </html>
    ';

    $obj_funciones = new funciones();
    $user_email = $obj_funciones->getUserEmail($to_email);

    if (!$user_email) {
        echo "Error: No se pudo obtener el correo electrónico del usuario.";
        return false;
    }

    $data = [
        'sender' => [
            'name' => $senderName,
            'email' => $senderEmail
        ],
        'to' => [
            [
                'email' => $user_email
            ]
        ],
        'subject' => $subject,
        'htmlContent' => $htmlContent
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.sendinblue.com/v3/smtp/email");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    ]);

    // Ejecutar la solicitud cURL y verificar el resultado
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        curl_close($ch);
        return false;
    } else {
        curl_close($ch);
        return $httpCode == 201; 
    }
}
?>
