<?php
require 'config.php';

$lista = [];
$sql = $pdo->query("SELECT * FROM tarefa");
if($sql->rowCount() > 0){
    $lista = $sql->fetchAll(PDO::FETCH_ASSOC);
}
?>

<h1>Lista de Tarefas</h1>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Ordem</th>
        <th>Nome</th>
        <th>Custo</th>
        <th>Prazo</th>
    </tr>
    <?php foreach($lista as $tarefa):?>
        <tr>
            <td><?=$tarefa['id'];?></td>
            <td><?=$tarefa['ordem'];?></td>
            <td><?=$tarefa['nome'];?></td>
            <td><?=$tarefa['custo'];?></td>
            <td><?=$tarefa['prazo'];?></td>
            <td>
                <a href="editar.php?id=<?=$tarefa['id'];?>">[Editar]</a>
                <a href  ="excluir.php?id=<?=$tarefa['id'];?>">[Excluir]</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<a href="cadastrar.php">Nova Tarefa</a>