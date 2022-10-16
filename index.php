<?php
require 'config.php';
$lista = [];
$sql = $pdo->query("SELECT * FROM tarefa ORDER BY ordem");
if ($sql->rowCount() > 0) {
    $lista = $sql->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
    <!--JQuery-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!--CSS local-->
    <link href="./style.css" rel="stylesheet">
</head>

<body class="bg-dark text-white" onload="corCusto()">
    <div class="container">
        <h1>Lista de Tarefas</h1>
        <table id="tabela" class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Custo (R$)</th>
                <th>Prazo</th>
                <th id="opcoes">Opções</th>
            </tr>

            <!--Lista as Tarefas-->
            <?php foreach ($lista as $tarefa) : ?>
                <tr data-tarefa="<?= $tarefa['id']; ?>">
                    <td><?= $tarefa['id']; ?></td>
                    <!--Não exibie a ordem-->
                    <td class="ordem d-none"><?= ($tarefa['ordem']) ?></td>
                    <td class="nome"><?= $tarefa['nome']; ?></td>
                    <td class="custo cor-custo"><?= $tarefa['custo']; ?></td>
                    <td class="prazo"><?= ($tarefa['prazo']) ?></td>

                    <!--Botões de Opções-->
                    <td>
                        <!--Subir Ordem-->
                        <form class="d-inline" method="POST" action="editar_action.php">
                            <input type="hidden" name="id" value="<?= $tarefa['id']; ?>" />
                            <input type="hidden" name="ordem" value="<?= $tarefa['ordem'] - 1; ?>" />
                            <button type="submit" id="botao-opcoes-ordem" class="btn btn-outline-dark"><img width="30" src="img/cima.png" alt="Botão subir"></button>
                        </form>

                        <!--Descer Ordem-->
                        <form class="d-inline" method="POST" action="editar_action.php">
                            <input type="hidden" name="id" value="<?= $tarefa['id']; ?>" />
                            <input type="hidden" name="ordem" value="<?= $tarefa['ordem'] + 1; ?>" />
                            <button type="submit" id="botao-opcoes-ordem" class="btn btn-outline-dark"><img width="30" src="img/baixo.png" alt="Botão descer"></button>
                        </form>

                        <!-- Editar Tarefa -->
                        <button type="button" id="botao-opcoes" class="btn btn-info" onclick="abrirModalEditar(<?= $tarefa['id']; ?>)"><img class="icon" width="30" src="img/editar.png" alt="Ícone Editar"></button>

                        <!-- Excluir Tarefa -->
                        <button type="button" id="botao-opcoes" data-id="<?= $tarefa['id']; ?>" class="btn btn-danger" onclick="abrirModalExcluir(<?= $tarefa['id']; ?>)" data-toggle="modal" data-target="#modal_excluir"><img class="icon" width="30" src="img/excluir.png" alt="Ícone Excluir"></button>

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
                <div class="modal-body text-center">

                    <!--Formulário de edição-->
                    <form method="POST" action="editar_action.php">
                        <input type="hidden" id="form_editar" name="id" />
                        <div class="container-md" id="formulario_editar">
                            <div class="row">
                                <div class="col-md-10 offset-md-1">
                                    <label>Nome: </label><input class="form-control" id="nome" type="text" name="nome" /><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 offset-md-1">
                                    <label>Custo (R$)</label><input class="form-control" id="custo" type="decimal" name="custo" /><br>
                                </div>
                                <div class="col-md-5 offset-md">
                                    <label>Prazo</label><input class="form-control" id="prazo" type="date" name="prazo" /><br>
                                </div>
                            </div>
                        </div>
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
                    <!--Formulário de exclusão-->
                    <form method="POST" action="excluir.php">
                        <input type="hidden" id="id" name="id" />
                        <input type="hidden" id="ordem" name="ordem" />
                        <button type="submit" class="btn btn-danger">Excluir</button>
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancelar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

</body>

<!--Modifica a cor do texto para custo acima de mil reais-->
<script>
    function corCusto() {
        $("#custo").keypress(function() {
            $(this).mask('R$ 999.990,00');
        });
        var custo = document.getElementsByClassName("cor-custo");
        var i;
        for (i = 0; i < custo.length; i++) {
            if (custo[i].innerHTML >= 1000) {
                custo[i].style.color = "#00FFFF";
            }
        }
    }

    //Envia os dados da tarefas para edição
    function abrirModalEditar(id) {
        var nome = $(`tr[data-tarefa=${id}] td.nome`).text();
        var custo = $(`tr[data-tarefa=${id}] td.custo`).text();
        var prazo = $(`tr[data-tarefa=${id}] td.prazo`).text();
        //Dados da tarefa para editar
        $('#form_editar').val(id);
        $('#nome').val(nome);
        $('#custo').val(custo);
        $('#prazo').val(prazo);
        $('#modal_editar').modal('show');
    }
    //Envia o ID da tarefa para excluir
    function abrirModalExcluir(id) {
        var ordem = $(`tr[data-tarefa=${id}] td.ordem`).text();
        $('#id').val(id);
        $('#ordem').val(ordem);
        $('#modal_xcluir').modal('show');
    }
</script>

</html>