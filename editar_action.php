<?php
require 'config.php';

//Busca o ID do usuário a ser editado
$id = filter_input(INPUT_POST, 'id');
$ordem = filter_input(INPUT_POST, 'ordem');
//$ordem-1;
$nome = filter_input(INPUT_POST, 'nome');
$custo = filter_input(INPUT_POST, 'custo');
$prazo = filter_input(INPUT_POST, 'prazo');

if($id && $nome!="" && $custo && $prazo){
    $sql = $pdo->prepare("UPDATE tarefa SET nome = :nome, custo = :custo, prazo = :prazo WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':custo', $custo);
    $sql->bindValue(':prazo', $prazo);
    $sql->execute();
    header("Location: index.php");
    exit;
}
else if($ordem){
    $sql = $pdo->prepare("SELECT id FROM tarefa WHERE ordem = :ordem");
    $sql->bindValue(':ordem', $ordem);
    $sql->execute();
    $id_antiga_ordem = $sql->fetchColumn();

    $sql = $pdo->prepare("SELECT ordem FROM tarefa WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
    $ordem_substituir_na_antiga = $sql->fetchColumn();

    $sql = $pdo->prepare("UPDATE tarefa SET ordem = :ordem WHERE id = :id");
    $sql->bindValue(':ordem', $ordem);
    $sql->bindValue(':id', $id);
    $sql->execute();


    $sql = $pdo->prepare("UPDATE tarefa SET ordem = :ordem WHERE id = :id");
    $sql->bindValue(':ordem', $ordem_substituir_na_antiga);
    $sql->bindValue(':id', $id_antiga_ordem);
    $sql->execute();

    header("Location: index.php");
    exit;
}

else{
    header("Location: index.php");
    exit;
}