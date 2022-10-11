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

<!-- Bootstrap-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!--Arquivo de estilo .css externo-->
<link href="./style.css" rel="stylesheet">

<div class="container">
    <h1>Editar Tarefa</h1>
    <form method="POST" action="editar_action.php">
        <input type="hidden" name="id" value="<?=$tarefa['id'];?>"/>
        <label>
            Nome: <input type="text" name="nome" value="<?=$tarefa['nome'];?>"/>
        </label>
        <label>
            Custo (R$): <input type="decimal" name="custo" value="<?=$tarefa['custo'];?>"/>
        </label>
        <label>
            Prazo: <input type="date" name="prazo" value="<?=$tarefa['prazo'];?>"/>
        </label>
        <br><br>
        <input class="btn btn-primary" type="submit" value="Atualizar">
    </form>
</div>