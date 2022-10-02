<?php
require 'config.php';

//Busca o ID do usuário a ser editado
$id = filter_input(INPUT_POST, 'id');
//$ordem = filter_input(INPUT_POST, 'ordem');
$nome = filter_input(INPUT_POST, 'nome');
$custo = filter_input(INPUT_POST, 'custo');
$prazo = filter_input(INPUT_POST, 'prazo');

if($id && $nome && $custo && $prazo){
    $sql = $pdo->prepare("UPDATE tarefa SET nome = :nome, custo = :custo, prazo = :prazo WHERE id = :id");
    $sql->bindValue(':id', $id);
    //$sql->bindValue(':ordem', $ordem);
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':custo', $custo);
    $sql->bindValue(':prazo', $prazo);
    $sql->execute();
    echo("Deu certo patrão!");
    header("Location: index.php");
    exit;
}

else{
    header("Location: index.php");
    exit;
}