<?php
require 'config.php';
//Recebe a ser excuída tarefa pelo seu ID
$id = filter_input(INPUT_POST,'id');
if ($id) {
    $sql = $pdo->prepare("DELETE FROM tarefa WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
}
//Retorna para o início
header("Location: index.php");
?>