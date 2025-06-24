<?php
require_once("cabecalho.php");

if (!isset($_SESSION['id'])) {
    die("Acesso negado! Usuário não está logado.");
}

function consultaTecnico($id)
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM tecnicos WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $tecnico = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$tecnico) {
            die("Técnico não encontrado!");
        } else {
            return $tecnico;
        }
    } catch (Exception $e) {
        die("Erro ao consultar técnico: " . $e->getMessage());
    }
}

function alteraTecnico($id, $nome, $login, $senhaDigitada)
{
    require("conexao.php");

    $stmt = $pdo->prepare("SELECT senha FROM tecnicos WHERE id = ?");
    $stmt->execute([$id]);
    $tecnico = $stmt->fetch(PDO::FETCH_ASSOC);

    $senhaFinal = empty($senhaDigitada)
        ? $tecnico['senha']
        : password_hash($senhaDigitada, PASSWORD_DEFAULT);

    try {
        $sql = "UPDATE tecnicos SET nome = ?, login = ?, senha = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $login, $senhaFinal, $id])) {
            $_SESSION['tecnico'] = $nome;
            header('location: principal.php?edicao=true');
            exit();
        } else {
            header('location: principal.php?edicao=false');
            exit();
        }
    } catch (Exception $e) {
        die("Erro ao alterar técnico: " . $e->getMessage());
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_SESSION['id'];
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    alteraTecnico($id, $nome, $login, $senha);
} else {
    $tecnico = consultaTecnico($_SESSION['id']);
}
?>

<h2>Editar Técnico</h2>

<form method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($tecnico['id']) ?>">

    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input value="<?= htmlspecialchars($tecnico['nome']) ?>"
            type="text" id="nome" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="login" class="form-label">Login (E-mail)</label>
        <input value="<?= htmlspecialchars($tecnico['login']) ?>"
            type="email" id="login" name="login" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="senha" class="form-label">Senha</label>
        <input type="password" name="senha" class="form-control">
        <small class="text-muted">Deixe em branco para manter a senha atual.</small>
    </div>

    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    <a href="principal.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php
require_once("rodape.php");
?>