<!--Listar Tarefas-->
<?php
require 'config.php';

$lista = [];
$sql = $pdo->query("SELECT * FROM tarefa ORDER BY ordem");
if ($sql->rowCount() > 0) {
    $lista = $sql->fetchAll(PDO::FETCH_ASSOC);
}

//Editar Tarefa
$tarefa = [];
$id = filter_input(INPUT_GET, 'id');
if ($id) {
    $sql = $pdo->prepare("SELECT * FROM tarefa WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
    if ($sql->rowCount() > 0) {
        $tarefa = $sql->fetch(PDO::FETCH_ASSOC);
    }
}
function data($data){
    return date("d/m/Y", strtotime($data));
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!--JQuery-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!--Arquivo de estilo .css externo-->
    <link href="./style.css" rel="stylesheet">
</head>

<body onload="condicional()">
    <div class="container">
        <h1>Lista de Tarefas</h1>
        <table border="1">
            <tr id="tabela">
                <th>ID</th>
                <th>Nome</th>
                <th>Custo (R$)</th>
                <th>Prazo</th>
                <th>Opções</th>
            </tr>

            <!--Lista as tarefas-->
            <?php foreach ($lista as $tarefa) : ?>
                <tr data-tarefa="<?= $tarefa['id']; ?>">
                    <td><?= $tarefa['id']; ?></td>
                    <td class="nome"><?= $tarefa['nome']; ?></td>
                    <!-- =number_format($tarefa['custo'], 2, ',', '.'); -->
                    <td class="custo cor-custo"><?= $tarefa['custo']; ?></td>
                    <td class="prazo"><?= data($tarefa['prazo']) ?></td>

                    <!--Botões de Opções-->
                    <td>
                        <!--Subir Ordem-->
                        <form class="d-inline" method="POST" action="editar_action.php">
                            <input type="hidden" name="id" value="<?= $tarefa['id']; ?>" />
                            <input type="hidden" name="ordem" value="<?= $tarefa['ordem'] - 1; ?>" />
                            <button type="submit" id="botao-opcoes" class="btn btn-outline-dark"><img width="30" src="img/cima.png" alt="Botão subir"></button>
                        </form>

                        <!--Descer Ordem-->
                        <form class="d-inline" method="POST" action="editar_action.php">
                            <input type="hidden" name="id" value="<?= $tarefa['id']; ?>" />
                            <input type="hidden" name="ordem" value="<?= $tarefa['ordem'] + 1; ?>" />
                            <button type="submit" id="botao-opcoes" class="btn btn-outline-dark"><img width="30" src="img/baixo.png" alt="Botão descer"></button>
                        </form>

                        <!--Editar-->
                        <a href="editar.php?id=<?= $tarefa['id']; ?>"><button type="button" class="btn btn-outline-info">Editar</button></a>
                        
                        <!-- Botão para excluir -->
                        <button type="button" id="botao-opcoes" class="btn btn-info" onclick="chamaModal(<?= $tarefa['id']; ?>)"><img class="icon" width="30" src="img/editar.png" alt="Ícone Excluir"></button>

                        <!-- Botão para excluir -->
                        <button type="button" id="botao-opcoes" class="btn btn-danger" data-toggle="modal" data-target="#modal_excluir"><img class="icon" width="30" src="img/excluir.png" alt="Ícone Excluir"></button>

                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <a href="cadastrar.php"><button type="button" class="btn btn-primary">Nova Tarefa</button></a>
    </div>

                <!--Modal para editar-->
                <div class="modal" id="modal_editar" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Tarefa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <!--Formulário de edição-->
                                        <form method="POST" action="editar_action.php">
                                            <input type="hidden" id="formulario" name="id" value="" />
                                            <label>
                                                <b>Nome</b><br><input id="nome" type="text" name="nome" />
                                            </label><br>
                                            <label>
                                                <b>Custo (R$)</b><br><input id="custo" type="decimal" name="custo" />
                                            </label><br>
                                            <label>
                                                <b>Prazo</b><br><input id="prazo" type="date" name="prazo" />
                                            </label><br><br>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Atualizar</button>
                                                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancelar</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para excluir-->
                        <div class="modal fade" id="modal_excluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Excluir tarefa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza, a tarefa será excluída permanentemente?
                                    </div>
                                    <div class="modal-footer">
                                        <a href="excluir.php?id=<?= $tarefa['id']; ?>"><button type="button" class="btn btn-danger">Excluir</button></a>
                                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

</body>

<!--Condição de cor-->
<script>
    function condicional() {
        var tds = document.getElementsByClassName("cor-custo");
        var i;
        for (i = 0; i < tds.length; i++) {
            if (tds[i].innerHTML >= 1000) {
                tds[i].style.color = "#17a2b8";
            }
        }
    }
    //Query de JQuery
    function chamaModal(id){
        var nome = $(`tr[data-tarefa=${id}] td.nome`).text();
        var custo = $(`tr[data-tarefa=${id}] td.custo`).text();
        var prazo = $(`tr[data-tarefa=${id}] td.prazo`).text();
        $('#formulario').val(id);
        $('#nome').val(nome);
        $('#custo').val(custo);
        $('#prazo').val(prazo);
        $('#modal_editar').modal('show');
    }

</script>

</html>