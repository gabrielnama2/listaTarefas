<?php
require 'config.php';

//Recebe os valores via POST
$id = filter_input(INPUT_POST, 'id');
$ordem = filter_input(INPUT_POST, 'ordem');
$nome = filter_input(INPUT_POST, 'nome');
$custo = filter_input(INPUT_POST, 'custo');
$prazo = filter_input(INPUT_POST, 'prazo');

//Conta a quantidade de tarefas
$sql = $pdo->query("SELECT COUNT(id) FROM tarefa");
$qtd_tarefas = $sql->fetchColumn();

//Valida o custo
if ($custo < 0) {
    echo("");
    echo "<script>alert('Seu custo não pode ser negativo.');location.href=\"index.php\";</script>";
    exit;
    //header("Location: index.php");
}

//Valida o nome
$sql = $pdo->prepare("SELECT id FROM tarefa WHERE nome = :nome");
$sql->bindValue(':nome', $nome);
$sql->execute();
$valida_nome = $sql->fetchColumn();

if ($valida_nome && $valida_nome != $id) {
    echo "<script>alert('Essa tarefa já existe!');location.href=\"index.php\";</script>";
    exit;
}

//Edita os dados da tarefa selecionada
if ($id && $nome != "" && $custo && $prazo) {
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
else if ($ordem > 0 && $ordem <= $qtd_tarefas) {
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
    //Retorna para o início
    header("Location: index.php");
    exit;
} else {
    //Retorna para o início
    header("Location: index.php");
    exit;
}
?>
