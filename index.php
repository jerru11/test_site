<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">

    <link rel="stylesheet" href="bootstrap.css" >

</head>
<body>


<?php
include_once "class.php";
/**
 * Создаём объект тестового класса
 */
$obj= new myTest;
/**
 * Выводим результат данных из sql
 */
$obj->get('failed');


?>


</body>
</html>
