<?php

require_once __DIR__ . '/helpers.php';

session_start();

$idUser = $_SESSION['user']['id'];

$pass = $_POST['pass'];
$login = $_POST['login'];
$email = $_POST['email'];
$tel = $_POST['tel'];

if ($idUser == '') {
    header("Location: /");
} else {
    // Меняем пароль

    $connect = getDB();
    $sql = "UPDATE `users` SET `pass` = ('$pass'), `login` = ('$login'), `email` = ('$email'), `tel` = ('$tel') WHERE `users`.`id` = ('$idUser')";

    if ($connect -> query($sql) === TRUE) {
        header("Location: /profile.php");
    } else {
        echo 'Произошла ошибка!';
    }
}