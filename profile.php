<?php

session_start();

require_once __DIR__ . '\src\helpers.php';

$connect = getDB();

$idUser = $_SESSION['user']['id'];

if ($idUser == '') {
    header("Location: /");
}

$sql = "SELECT * FROM `users` WHERE `id` = ('$idUser')";

$result = mysqli_query($connect, $sql);
$result = mysqli_fetch_all($result);

$login;
$pass;
$tel;
$email;

foreach($result as $item) {
    $login = $item[1];
    $pass = $item[2];
    $email = $item[3];
    $tel = $item[4];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Профиль</title>
</head>
<body>
    
<main>

    <h2>Личный кабинет</h2>

    <p>Добро пожаловать, <?= $login ?>!</p>

    <a href="src/logout.php">Выход</a><br><br>
    <a href="index.html">Главная страница</a>

</main>

<main>

    <h2>Изменить данные профиля</h2>

    <form action="src/editPassword.php" method="post">
        <span>Пароль:</span>
        <input name="pass" type="text" value="<?= $pass ?>">

        <span>Логин:</span>
        <input name="login" type="text" value="<?= $login ?>">

        <span>Почта:</span>
        <input name="email" type="text" value="<?= $email ?>">

        <span>Телефон:</span>
        <input name="tel" type="double" value="<?= $tel ?>">

        <button type="submit">Сохранить данные</button>
    </form>

</main>

</body>
</html>