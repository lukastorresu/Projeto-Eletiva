<?php
require_once("cabecalho.php");

echo "<h2> Técnico: " . $_SESSION['tecnico'] . " </h2>";
?>
<p><a href="sair.php">Sair</a></p>
<?php
require_once("rodape.php");
?>