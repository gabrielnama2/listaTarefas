<?php
require 'config.php';
//Busca a tarefa pelo seu ID
$id = filter_input(INPUT_GET, 'id');
if ($id) {
    $sql = $pdo->prepare("DELETE FROM tarefa WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
}
//Retorna para o início
header("Location: index.php");
?>