<?php

declare(strict_types=1);

$dominio = 'mysql:host=localhost;dbname=projetophp';
$usuario = 'root';
$senha = '';

try {
    $pdo = new PDO($dominio, $usuario, $senha);
} catch (PDOException $e) {
    die("Erro ao conectar com o banco! " . $e->getMessage());
}
