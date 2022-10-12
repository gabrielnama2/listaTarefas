<?php
require 'config.php';
//Recebe os valor via POST
$nome = filter_input(INPUT_POST, 'nome');
$custo = filter_input(INPUT_POST, 'custo');
$prazo = filter_input(INPUT_POST, 'prazo');

if($nome && $custo && $prazo){
    //Verifica se a tarefa já foi criada no DB
    $sql = $pdo->prepare("SELECT * FROM tarefa WHERE nome = :nome");
    $sql->bindValue(':nome', $nome);
    $sql->execute();
    //Atribui os dados da tarefa para a tabela no DB
    if($sql->rowCount() === 0){
        $sql = $pdo->prepare("INSERT INTO tarefa(nome, custo, prazo) VALUES(:nome, :custo, :prazo)");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':custo', $custo);
        $sql->bindValue(':prazo', $prazo);
        $sql->execute();
        //Retorna para o início
        header("Location: index.php");
        exit;
    }
    else{
        //Retorna para o início
        header("Location: cadastrar.php");
    }
}
else{
    //Mensagem de erro
    echo("OPS, algo deu errado.");
    header("Location: cadastrar.php");
    exit;
}
?>