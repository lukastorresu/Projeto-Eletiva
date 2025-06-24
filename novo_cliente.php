<?php
require_once("cabecalho.php");

function inserirCliente($nome, $telefone, $email, $endereco)
{
    require("conexao.php");
    try {
        $sql = "INSERT INTO clientes (nome, telefone, email, endereco) VALUES (?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $telefone, $email, $endereco])) {
            header('location: clientes.php?cadastro=true');
        } else {
            header('location: clientes.php?cadastro=false');
        }
    } catch (Exception $e) {
        die("Erro ao inserir o cliente: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    inserirCliente($nome, $telefone, $email, $endereco);
}
?>

<h2>Novo Cliente</h2>

<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" id="nome" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="telefone" class="form-label">Telefone</label>
        <input type="text" id="telefone" name="telefone" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="endereco" class="form-label">Endereco</label>
        <input type="text" id="endereco" name="endereco" class="form-control" required>
    </div>


    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="clientes.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php
require_once("rodape.php");
?>