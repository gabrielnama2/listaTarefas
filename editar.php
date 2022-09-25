<?php
require 'config.php';

//Busca o ID da tarefa a ser editada
$tarefa = [];
$id = filter_input(INPUT_GET, 'id');
if($id){
    $sql = $pdo->prepare("SELECT * FROM tarefa WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
    if($sql->rowCount() > 0){
        $tarefa = $sql->fetch(PDO::FETCH_ASSOC);
    }
    else{
        header("Location: index.php");
        exit;
    }
}
else{
    header("Location: index.php");
}
?>

<h1>Editar Tarefa</h1>
<form method="POST" action="editar_action.php">
    <input type="hidden" name="id" value="<?=$tarefa['id'];?>"/>
    <label>
        ID: <input type="number" name="id" value="<?=$tarefa['id'];?>"/>
    </label>
    <label>
        Ordem: <input type="number" name="ordem" value="<?=$tarefa['ordem'];?>"/>
    </label>
    <label>
        Nome: <input type="text" name="nome" value="<?=$tarefa['nome'];?>"/>
    </label>
    <label>
        Custo: <input type="text" name="custo" value="<?=$tarefa['custo'];?>"/>
    </label>
    <label>
        Prazo: <input type="text" name="prazo" value="<?=$tarefa['prazo'];?>"/>
    </label>
    <input type="submit" value="Atualizar">
</form>