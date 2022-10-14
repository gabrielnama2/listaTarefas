<?php
require 'config.php';
//Recebe os valores da tarefa via POST
$id = filter_input(INPUT_POST, 'id');
$ordem = filter_input(INPUT_POST, 'ordem');
//Busca a quantidade total de tarefas
$sql = $pdo->query("SELECT COUNT(id) FROM tarefa");
$qtd_tarefas = $sql->fetchColumn();

//Move a tarefa para última, antes de excluir
while ($ordem <= $qtd_tarefas) {
    $sql = $pdo->prepare("SELECT id FROM tarefa WHERE ordem = :ordem");
    $sql->bindValue(':ordem', $ordem);
    $sql->execute();
    $id_antiga_ordem = $sql->fetchColumn();

    $sql = $pdo->prepare("SELECT ordem FROM tarefa WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
    $ordem_substituir_na_antiga = $sql->fetchColumn();

    $sql = $pdo->prepare("UPDATE tarefa SET ordem = :ordem WHERE id = :id AND ordem < (SELECT MAX(id) FROM tarefa);");
    $sql->bindValue(':ordem', $ordem);
    $sql->bindValue(':id', $id);
    $sql->execute();

    $sql = $pdo->prepare("UPDATE tarefa SET ordem = :ordem WHERE id = :id");
    $sql->bindValue(':ordem', $ordem_substituir_na_antiga);
    $sql->bindValue(':id', $id_antiga_ordem);
    $sql->execute();
    
    $ordem++;
}
//Exclui a tarefa pelo seu ID
if ($id) {
    $sql = $pdo->prepare("DELETE FROM tarefa WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
}
//Retorna para o início
header("Location: index.php");
exit;