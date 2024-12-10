<?php
session_start();

require_once __DIR__ . '/helpers.php';
require_once('db.php');

$login = $_POST['login'];
$pass = $_POST['pass'];

define('SMARTCAPTCHA_SERVER_KEY', 'ysc2_123');

function check_captcha($token) {
    $ch = curl_init();
    $args = http_build_query([
        "secret" => SMARTCAPTCHA_SERVER_KEY,
        "token" => $token,
        "ip" => $_SERVER['REMOTE_ADDR'],
    ]);
    curl_setopt($ch, CURLOPT_URL, "https://smartcaptcha.yandexcloud.net/validate?$args");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);

    $server_output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode !== 200) {
        echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
        return true;
    }
    $resp = json_decode($server_output);
    return $resp->status === "ok";
}

$token = $_POST['smart-token'];
if (check_captcha($token)) {
    echo "Passed\n";
} else {
    echo "Robot\n";
}

try {
    $sql = "SELECT * FROM users WHERE (tel = '$login' OR email = '$login') AND pass = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user']['id'] = $row['id'];
        $_SESSION['user']['login'] = $row['tel']; 
        
        header("Location: /profile.php");
    } else {
        throw new Exception("Неверный логин или пароль");
    }

} catch (Exception $e) {
    echo "Произошла ошибка: " . $e->getMessage();
}
