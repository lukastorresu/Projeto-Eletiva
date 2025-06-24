<?php
require_once("cabecalho.php");

function consultaTipoChamado($id)
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM tipos_chamado WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $tipo = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$tipo) {
            die("Registro não encontrado!");
        } else {
            return $tipo;
        }
    } catch (Exception $e) {
        die("Erro ao consultar tipo de chamado: " . $e->getMessage());
    }
}

function alterarTipoChamado($nome, $descricao, $id)
{
    require("conexao.php");
    try {
        $sql = "UPDATE tipos_chamado SET nome = ?, descricao = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([$nome, $descricao, $id]);

        if ($success) {
            header('Location: tipos_chamado.php?edicao=true');
            exit();
        } else {
            error_log("Falha ao atualizar tipo de chamado ID: $id");
            header('Location: tipos_chamado.php?edicao=false');
            exit();
        }
    } catch (Exception $e) {
        error_log("ERRO SQL: " . $e->getMessage());
        error_log("SQL: $sql");
        error_log("Parâmetros: " . print_r([$nome, $descricao, $id], true));

        header('Location: tipos_chamado.php?edicao=false&erro=' . urlencode($e->getMessage()));
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $id = $_POST['id'];
    alterarTipoChamado($nome, $descricao, $id);
} else {
    if (!isset($_GET['id'])) {
        die("ID não informado!");
    }
    $tipo = consultaTipoChamado($_GET['id']);
}
?>

<h2>Editar Tipo de Chamado</h2>

<form method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($tipo['id']) ?>">

    <div class="mb-3">
        <label for="nome" class="form-label">Nome do Tipo</label>
        <input value="<?= htmlspecialchars($tipo['nome']) ?>"
            type="text" id="nome" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4" required><?= htmlspecialchars($tipo['descricao']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    <a href="tipos_chamado.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php
require_once("rodape.php");
?>