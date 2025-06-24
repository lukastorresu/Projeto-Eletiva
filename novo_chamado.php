<?php
require_once("cabecalho.php");

function retornaTiposChamado()
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM tipos_chamado";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar tipos de chamado: " . $e->getMessage());
    }
}

function retornaClientes()
{
    require("conexao.php");
    try {
        $sql = "SELECT id, nome FROM clientes";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar clientes: " . $e->getMessage());
    }
}

function retornaTecnicos()
{
    require("conexao.php");
    try {
        $sql = "SELECT id, nome FROM tecnicos";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar técnicos: " . $e->getMessage());
    }
}

function inserirChamado($descricao, $tipo_id, $cliente_id, $tecnico_id)
{
    require("conexao.php");
    try {
        $sql = "INSERT INTO chamados (descricao, tipo_id, cliente_id, tecnico_id, data_hora)
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$descricao, $tipo_id, $cliente_id, $tecnico_id])) {
            header("Location: consulta_chamados.php?cadastro=true");
            exit();
        } else {
            header("Location: consulta_chamados.php?cadastro=false");
            exit();
        }
    } catch (Exception $e) {
        die("Erro ao inserir chamado: " . $e->getMessage());
    }
}

$tiposChamado = retornaTiposChamado();
$clientes = retornaClientes();
$tecnicos = retornaTecnicos();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $descricao = $_POST['descricao'];
    $tipo_id = $_POST['tipo_id'];
    $cliente_id = $_POST['cliente_id'];
    $tecnico_id = $_POST['tecnico_id'];

    inserirChamado($descricao, $tipo_id, $cliente_id, $tecnico_id);
}
?>

<h2>Novo Chamado</h2>

<form method="post">
    <div class="mb-3">
        <label for="cliente_id" class="form-label">Cliente</label>
        <select id="cliente_id" name="cliente_id" class="form-select" required>
            <option value="">Selecione um cliente...</option>
            <?php foreach ($clientes as $cli): ?>
                <option value="<?= htmlspecialchars($cli['id']) ?>">
                    <?= htmlspecialchars($cli['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="tipo_id" class="form-label">Tipo de Chamado</label>
        <select id="tipo_id" name="tipo_id" class="form-select" required>
            <option value="">Selecione um tipo...</option>
            <?php foreach ($tiposChamado as $tipo): ?>
                <option value="<?= htmlspecialchars($tipo['id']) ?>">
                    <?= htmlspecialchars($tipo['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="tecnico_id" class="form-label">Técnico</label>
        <select id="tecnico_id" name="tecnico_id" class="form-select" required>
            <option value="">Selecione um técnico...</option>
            <?php foreach ($tecnicos as $tec): ?>
                <option value="<?= htmlspecialchars($tec['id']) ?>">
                    <?= htmlspecialchars($tec['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="3" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="consulta_chamados.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php
require_once("rodape.php");
?>