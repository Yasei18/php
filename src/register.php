<?php

session_start();
require_once __DIR__ . '\helpers.php';
require_once('db.php');

$login = trim($_POST['login']);
$tel = trim($_POST['tel']);
$pass = trim($_POST['pass']);
$repeatpass = trim($_POST['repeatpass']);
$email = trim($_POST['email']);

$connect = getDB();

// Проверка заполнения всех полей
if (empty($login) || empty($tel) || empty($email) || empty($pass) || empty($repeatpass)) {
    echo "Заполните все поля";
} else {
    // Сравнение паролей
    if ($pass != $repeatpass) {
        echo "Пароли не совпадают";
    } else {
        // Проверка уникальности email
        $checkEmail = mysqli_query($connect, "SELECT * FROM users WHERE email = '$email'");
        if (mysqli_num_rows($checkEmail) > 0) {
            echo "Этот email уже зарегистрирован";
        } else {
            // Проверка уникальности логина
            $checkLogin = mysqli_query($connect, "SELECT * FROM users WHERE login = '$login'");
            if (mysqli_num_rows($checkLogin) > 0) {
                echo "Этот логин уже используется";
            } else {
                // Проверка уникальности телефона
                $checkTel = mysqli_query($connect, "SELECT * FROM users WHERE tel = '$tel'");
                if (mysqli_num_rows($checkTel) > 0) {
                    echo "Этот номер телефона уже зарегистрирован";
                } else {
                    // Вставка данных в базу
                    $sql = "INSERT INTO users (login,tel,email,pass) VALUES ('$login', '$tel', '$email', '$pass')";
                    if ($connect->query($sql) === TRUE) {
                        echo "Успешная регистрация";
                        header("Location: /login.html");
                        header('Location: /');
                    } else {
                        echo "Ошибка при регистрации: " . $connect->error;
                    }
                }
            }
        }
    }
}
