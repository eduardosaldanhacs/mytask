<?php
$id = '';
$id = isset($_SESSION['id']);
$tarefaDAO = new TarefaDAO($conn, $BASE_URL);
$tarefaOBJ = new Tarefa();
$tarefa = $tarefaDAO->recuperarTarefaId($id);
$data_formatada = $tarefaOBJ->formataData(($tarefa['data_cadastro']));
$status = $tarefaOBJ->situacaoStatus($tarefa['id_status']);
?>
<div class="sections-container">
    <h2>Editar</h2>
    <section class="first-section">
        <p id=>Nome da tarefa: <?= ($tarefa['tarefa']) ?></p>
        <p>Data da tarefa: <?= $data_formatada ?></p>
        <p>Situação da tarefa: <span id="<?= $status ?>"><?= $status ?></span></p>
    </section>
    <section class="second-section">
        <h4>Preencha os novos dados</h4>
        <form action="cadastra.php" method="POST">
            <? $_SESSION['id'] = $id ?>
            <input type="hidden" name="type" value="editar">
            <label for="">Tarefa:</label>
            <input type="text" name="tarefa" placeholder="Digite o nome da tarefa">
            <label for="">Situação:</label>
            <select name="status" id="">
                <option value=2>Concluido</option>
                <option value=1>Pendente</option>
            </select>
            <input type="submit" value="Atualizar" id="button" class="edit-button2">
        </form>
    </section>
</div>