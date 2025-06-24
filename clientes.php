<?php
require_once("cabecalho.php");

function excluirCliente($id)
{
    require("conexao.php");
    try {
        $sql = "DELETE FROM clientes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id])) {
            header('location: clientes.php?exclusao=true');
            exit();
        } else {
            header('location: clientes.php?exclusao=false');
            exit();
        }
    } catch (Exception $e) {
        header('location: clientes.php?exclusao=false');
        exit();
    }
}

if (isset($_GET['excluir'])) {
    excluirCliente($_GET['excluir']);
}

function retornaClientes()
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM clientes";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar os clientes: " . $e->getMessage());
    }
}

$clientes = retornaClientes();
?>

<script>
    function confirmarExclusao(id) {
        if (confirm('Tem certeza que deseja excluir este cliente?')) {
            window.location.href = 'clientes.php?excluir=' + id;
        }
    }
</script>

<h2>Clientes</h2>
<a href="novo_cliente.php" class="btn btn-success mb-3">Novo Registro</a>

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
            <th>Telefone</th>
            <th>E-mail</th>
            <th>Endereço</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clientes as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['id']) ?></td>
                <td><?= htmlspecialchars($c['nome']) ?></td>
                <td><?= htmlspecialchars($c['telefone']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['endereco']) ?></td>
                <td>
                    <a href="editar_cliente.php?id=<?= $c['id'] ?>" class="btn btn-warning">Editar</a>
                    <button onclick="confirmarExclusao(<?= $c['id'] ?>)" class="btn btn-danger">Excluir</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
require_once("rodape.php");
?>