<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<div class="container">
<br><br>
<h1>Nova Tarefa</h1>
    <form method = "POST" action="cadastrar_action.php">
        <label>
            Ordem: <input type="number" name="ordem">
        </label>
        <label>
            Nome: <input type="text" name="nome">
        </label>
        <label>
            Custo: <input type="text" name="custo">
        </label>
        <label>
            Prazo: <input type="text" name="prazo">
        </label>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>