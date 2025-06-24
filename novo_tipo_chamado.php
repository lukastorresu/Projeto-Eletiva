<?php
require_once("cabecalho.php");

function inserirTipoChamado($nome, $descricao)
{
    require("conexao.php");
    try {
        $sql = "INSERT INTO tipos_chamado (nome, descricao) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $descricao])) {
            header('location: tipos_chamado.php?cadastro=true');
        } else {
            header('location: tipos_chamado.php?cadastro=false');
        }
    } catch (Exception $e) {
        die("Erro ao inserir o tipo de chamado: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    inserirTipoChamado($nome, $descricao);
}
?>

<h2>Novo Tipo de Chamado</h2>

<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome do Tipo</label>
        <input type="text" id="nome" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="tipos_chamado.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php
require_once("rodape.php");
?>