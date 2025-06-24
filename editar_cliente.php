<?php
require_once("cabecalho.php");

function consultaCliente($id)
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM clientes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $tipo = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$tipo) {
            die("Registro não encontrado!");
        } else {
            return $tipo;
        }
    } catch (Exception $e) {
        die("Erro ao consultar cliente: " . $e->getMessage());
    }
}

function alteraCliente($id, $nome, $email, $telefone, $endereco)
{
    require("conexao.php");
    try {
        $sql = "UPDATE clientes SET nome = ?, email = ?, telefone = ?, endereco = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $email, $telefone, $endereco, $id])) {
            header('location: clientes.php?edicao=true');
            exit();
        } else {
            header('location: clientes.php?edicao=false');
            exit();
        }
    } catch (Exception $e) {
        die("Erro ao alterar cliente: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    alteraCliente($id, $nome, $email, $telefone, $endereco);
} else {
    if (!isset($_GET['id'])) {
        die("ID não informado!");
    }
    $tipo = consultaCliente($_GET['id']);
}
?>

<h2>Editar cliente</h2>

<form method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($tipo['id']) ?>">

    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input value="<?= htmlspecialchars($tipo['nome']) ?>"
            type="text" id="nome" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input value="<?= htmlspecialchars($tipo['email']) ?>"
            type="text" id="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="telefone" class="form-label">Telefone</label>
        <input value="<?= htmlspecialchars($tipo['telefone']) ?>"
            type="text" id="telefone" name="telefone" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="endereco" class="form-label">Endereço</label>
        <input value="<?= htmlspecialchars($tipo['endereco']) ?>"
            type="text" id="endereco" name="endereco" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    <a href="clientes.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php
require_once("rodape.php");
?>