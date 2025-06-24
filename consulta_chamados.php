<?php
require_once("cabecalho.php");

function excluirChamado($id)
{
    require("conexao.php");
    try {
        $sql = "DELETE FROM chamados WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id])) {
            header('location: consulta_chamados.php?exclusao=true');
            exit();
        } else {
            header('location: consulta_chamados.php?exclusao=false');
            exit();
        }
    } catch (Exception $e) {
        header('location: consulta_chamados.php?exclusao=false');
        exit();
    }
}

if (isset($_GET['excluir'])) {
    excluirChamado($_GET['excluir']);
}

function retornaChamados()
{
    require("conexao.php");
    try {
        $sql = "SELECT c.*, 
                       t.nome as nome_tipo,
                       cli.nome as nome_cliente,
                       tec.nome as nome_tecnico
                FROM chamados c
                INNER JOIN tipos_chamado t ON t.id = c.tipo_id
                INNER JOIN clientes cli ON cli.id = c.cliente_id
                INNER JOIN tecnicos tec ON tec.id = c.tecnico_id
                ORDER BY c.data_hora DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar chamados: " . $e->getMessage());
    }
}

$chamados = retornaChamados();
?>

<h2>Chamados</h2>

<?php
if (isset($_GET['cadastro'])) {
    echo $_GET['cadastro'] ? '<div class="alert alert-success">Registro salvo com sucesso!</div>' : '<div class="alert alert-danger">Erro ao inserir o registro!</div>';
}

if (isset($_GET['edicao'])) {
    echo $_GET['edicao'] ? '<div class="alert alert-success">Registro alterado com sucesso!</div>' : '<div class="alert alert-danger">Erro ao alterar o registro!</div>';
}

if (isset($_GET['exclusao'])) {
    echo $_GET['exclusao'] ? '<div class="alert alert-success">Registro excluído com sucesso!</div>' : '<div class="alert alert-danger">Erro ao excluir o registro!</div>';
}
?>

<a href="novo_chamado.php" class="btn btn-success mb-3">Novo Registro</a>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tipo de Chamado</th>
            <th>Cliente</th>
            <th>Técnico</th>
            <th>Descrição</th>
            <th>Data/Hora</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($chamados as $ch): ?>
            <tr>
                <td><?= htmlspecialchars($ch['id']) ?></td>
                <td><?= htmlspecialchars($ch['nome_tipo']) ?></td>
                <td><?= htmlspecialchars($ch['nome_cliente']) ?></td>
                <td><?= htmlspecialchars($ch['nome_tecnico']) ?></td>
                <td><?= htmlspecialchars($ch['descricao']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($ch['data_hora'])) ?></td>
                <td>
                    <a href="editar_chamado.php?id=<?= $ch['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <button onclick="confirmarExclusao(<?= $ch['id'] ?>)" class="btn btn-danger btn-sm">Excluir</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function confirmarExclusao(id) {
        if (confirm('Tem certeza que deseja excluir este chamado?')) {
            window.location.href = 'consulta_chamados.php?excluir=' + id;
        }
    }
</script>

<?php
require_once("rodape.php");
?>