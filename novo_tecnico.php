<?php
require_once("conexao.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    try {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $login = $_POST['login'];
        $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO tecnicos (id,nome, login, senha) VALUES (?,?,?,?)");
        if ($stmt->execute([$id, $nome, $login, $senha])) {
            header("location: index.php?cadastro=true");
        } else {
            echo "<p>Erro ao inserir o tecnico</p>";
        }
    } catch (Exception $e) {
        echo "Erro ao inserir tecnico" . $e->getMessage();
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Novo Técnico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <main class="container">
        <h1>Novo Técnico</h1>

        <form method="post">

            <div class="mb-3">
                <label for="nome" class="form-label">Informe o nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" required="">
            </div>

            <div class="mb-3">
                <label for="login" class="form-label">Informe o login:</label>
                <input type="email" id="login" name="login" class="form-control" required="">
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Informe a senha:</label>
                <input type="password" id="senha" name="senha" class="form-control" required="">
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>