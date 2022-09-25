<?php

$db_name = 'sistema_tarefas';
$db_host = 'localhost:3306';
$db_user = 'root';
$db_password = '';
$pdo = new PDO("mysql:dbname=".$db_name.";host=".$db_host, $db_user, $db_password);