<?php
require_once("cabecalho.php");

function consultaChamado($id)
{
    require("conexao.php");
    try {
        $sql = "SELECT c.*, 
                       t.nome as tipo_nome,
                       cli.nome as cliente_nome,
                       tec.nome as tecnico_nome
                FROM chamados c
                LEFT JOIN tipos_chamado t ON t.id = c.tipo_id
                LEFT JOIN clientes cli ON cli.id = c.cliente_id
                LEFT JOIN tecnicos tec ON tec.id = c.tecnico_id
                WHERE c.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $chamado = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$chamado) {
            die("Chamado não encontrado!");
        }
        return $chamado;
    } catch (Exception $e) {
        die("Erro ao consultar chamado: " . $e->getMessage());
    }
}

function alteraChamado($id, $tipo_id, $cliente_id, $tecnico_id, $descricao)
{
    require("conexao.php");
    try {
        $sql = "UPDATE chamados SET 
                tipo_id = ?, 
                cliente_id = ?, 
                tecnico_id = ?, 
                descricao = ? 
                WHERE id = ?";

        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([$tipo_id, $cliente_id, $tecnico_id, $descricao, $id]);

        if ($success) {
            header('Location: consulta_chamados.php?edicao=true');
            exit();
        } else {
            header('Location: consulta_chamados.php?edicao=false');
            exit();
        }
    } catch (Exception $e) {
        die("Erro ao alterar chamado: " . $e->getMessage());
    }
}

function retornaTiposChamado()
{
    require("conexao.php");
    try {
        $sql = "SELECT id, nome FROM tipos_chamado";
        return $pdo->query($sql)->fetchAll();
    } catch (Exception $e) {
        die("Erro ao buscar tipos de chamado: " . $e->getMessage());
    }
}

function retornaClientes()
{
    require("conexao.php");
    try {
        $sql = "SELECT id, nome FROM clientes";
        return $pdo->query($sql)->fetchAll();
    } catch (Exception $e) {
        die("Erro ao buscar clientes: " . $e->getMessage());
    }
}

function retornaTecnicos()
{
    require("conexao.php");
    try {
        $sql = "SELECT id, nome FROM tecnicos";
        return $pdo->query($sql)->fetchAll();
    } catch (Exception $e) {
        die("Erro ao buscar técnicos: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $tipo_id = $_POST['tipo_id'];
    $cliente_id = $_POST['cliente_id'];
    $tecnico_id = $_POST['tecnico_id'];
    $descricao = $_POST['descricao'];

    alteraChamado($id, $tipo_id, $cliente_id, $tecnico_id, $descricao);
} else {
    if (!isset($_GET['id'])) {
        die("ID não informado!");
    }
    $chamado = consultaChamado($_GET['id']);
    $tipos = retornaTiposChamado();
    $clientes = retornaClientes();
    $tecnicos = retornaTecnicos();
}
?>

<h2>Editar Chamado</h2>

<form method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($chamado['id']) ?>">

    <div class="mb-3">
        <label for="tipo_id" class="form-label">Tipo de Chamado</label>
        <select id="tipo_id" name="tipo_id" class="form-select" required>
            <option value="">Selecione um tipo...</option>
            <?php foreach ($tipos as $tipo): ?>
                <option value="<?= htmlspecialchars($tipo['id']) ?>"
                    <?= ($tipo['id'] == $chamado['tipo_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($tipo['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="cliente_id" class="form-label">Cliente</label>
        <select id="cliente_id" name="cliente_id" class="form-select" required>
            <option value="">Selecione um cliente...</option>
            <?php foreach ($clientes as $cli): ?>
                <option value="<?= htmlspecialchars($cli['id']) ?>"
                    <?= ($cli['id'] == $chamado['cliente_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cli['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="tecnico_id" class="form-label">Técnico</label>
        <select id="tecnico_id" name="tecnico_id" class="form-select" required>
            <option value="">Selecione um técnico...</option>
            <?php foreach ($tecnicos as $tec): ?>
                <option value="<?= htmlspecialchars($tec['id']) ?>"
                    <?= ($tec['id'] == $chamado['tecnico_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($tec['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4" required><?=
                                                                                            htmlspecialchars($chamado['descricao'])
                                                                                            ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Data/Hora de Abertura</label>
        <input type="text" class="form-control" value="<?=
                                                        date('d/m/Y H:i', strtotime($chamado['data_hora']))
                                                        ?>" readonly>
    </div>

    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    <a href="consulta_chamados.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php
require_once("rodape.php");
?>