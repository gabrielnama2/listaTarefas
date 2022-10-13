<?php
require 'config.php';
//Recebe os valor via POST
$ultima_tarefa = "SELECT MAX(ordem) FROM tarefa;";
$id = filter_input(INPUT_POST, 'id');
$ordem = filter_input(INPUT_POST, 'ordem');
$nome = filter_input(INPUT_POST, 'nome');
$custo = filter_input(INPUT_POST, 'custo');
$prazo = filter_input(INPUT_POST, 'prazo');

//Edita os dados da tarefa selecionada
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

//Troca a ordem de apresentação
else if($ordem>0){
    echo($ultima_tarefa);
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
    //Retorna para o início
    header("Location: index.php");
    exit;
}

else{
    //Retorna para o início
    header("Location: index.php");
    exit;
}
?>