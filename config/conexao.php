<?php

$config = require __DIR__ . '/config.php';

try {
    $conexao = new PDO(
        "mysql:host={$config['host']};dbname={$config['banco']};charset=utf8mb4",
        $config['usuario'],
        $config['senha']
    );

    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erro ao conectar com o banco de dados.");
}