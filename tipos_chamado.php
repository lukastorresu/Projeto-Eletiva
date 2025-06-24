<?php
require_once("cabecalho.php");

function excluirTipoChamado($id)
{
    require("conexao.php");
    try {
        $sql = "DELETE FROM tipos_chamado WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id])) {
            header('location: tipos_chamado.php?exclusao=true');
            exit();
        } else {
            header('location: tipos_chamado.php?exclusao=false');
            exit();
        }
    } catch (Exception $e) {
        header('location: tipos_chamado.php?exclusao=false');
        exit();
    }
}

if (isset($_GET['excluir'])) {
    excluirTipoChamado($_GET['excluir']);
}

function retornaTiposChamado()
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM tipos_chamado";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar os tipos de chamado: " . $e->getMessage());
    }
}

$tiposChamado = retornaTiposChamado();
?>

<script>
    function confirmarExclusao(id) {
        if (confirm('Tem certeza que deseja excluir este tipo de chamado?')) {
            window.location.href = 'tipos_chamado.php?excluir=' + id;
        }
    }
</script>

<h2>Tipos de Chamado</h2>
<a href="novo_tipo_chamado.php" class="btn btn-success mb-3">Novo Registro</a>

<?php
if (isset($_GET['cadastro']) && $_GET['cadastro'] == true) {
    echo '<p class="text-success">Registro salvo com sucesso!</p>';
} elseif (isset($_GET['cadastro']) && $_GET['cadastro'] == false) {
    echo '<p class="text-danger">Erro ao inserir o registro!</p>';
}
if (isset($_GET['edicao']) && $_GET['edicao'] == true) {
    echo '<p class="text-success">Registro alterado com sucesso!</p>';
} elseif (isset($_GET['edicao']) && $_GET['edicao'] == false) {
    echo '<p class="text-danger">Erro ao alterar o registro!</p>';
}
if (isset($_GET['exclusao']) && $_GET['exclusao'] == true) {
    echo '<p class="text-success">Registro excluído com sucesso!</p>';
} elseif (isset($_GET['exclusao']) && $_GET['exclusao'] == false) {
    echo '<p class="text-danger">Erro ao excluir o registro!</p>';
}
?>

<table class="table table-hover table-striped" id="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tiposChamado as $tipo): ?>
            <tr>
                <td><?= htmlspecialchars($tipo['id']) ?></td>
                <td><?= htmlspecialchars($tipo['nome']) ?></td>
                <td><?= htmlspecialchars($tipo['descricao']) ?></td>
                <td>
                    <a href="editar_tipo_chamado.php?id=<?= $tipo['id'] ?>" class="btn btn-warning">Editar</a>
                    <button onclick="confirmarExclusao(<?= $tipo['id'] ?>)" class="btn btn-danger">Excluir</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
require_once("rodape.php");
?>