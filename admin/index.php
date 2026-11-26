
<?php
session_start();
require_once "../config/conexao.php";

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$sql = "SELECT produtos.*, categorias.nome AS categoria
        FROM produtos
        INNER JOIN categorias
        ON produtos.categoria_id = categorias.id
        ORDER BY produtos.id";

$produtos = $conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Painel Administrativo - Vértice Watches</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/estilo.css">
</head>

<body>

    <nav class="navbar">
        <div class="container">

            <a href="index.php" class="navbar-brand text-white fw-bold">
                VÉRTICE WATCHES | ADMIN
            </a>

            <div>
                <a href="../index.php" class="text-white me-3">Loja</a>
                <a href="../sair.php" class="text-white">Sair</a>
            </div>

        </div>
    </nav>

    <div class="container py-5">

        <h2 class="mb-3">Painel Administrativo</h2>

        <p>Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!</p>

        <a href="cadastrar.php" class="btn btn-produto mb-4">
            Cadastrar produto
        </a>

        <h4 class="mb-3">Produtos cadastrados</h4>

        <div class="table-responsive">

            <table class="table align-middle text-center">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Foto</th>
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($produtos as $produto): ?>

                        <tr>

                            <td><?= $produto['id'] ?></td>

                            <td>
                                <img src="../img/<?= htmlspecialchars($produto['imagem']) ?>"
                                     class="imagem-carrinho">
                            </td>

                            <td><?= htmlspecialchars($produto['nome']) ?></td>

                            <td><?= htmlspecialchars($produto['categoria']) ?></td>

                            <td>
                                R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                            </td>

                            <td><?= $produto['estoque'] ?></td>

                            <td>
                                <?= $produto['ativo'] ? 'Ativo' : 'Inativo' ?>
                            </td>

                            <td>
                                <a href="editar.php?id=<?= $produto['id'] ?>"
                                   class="btn btn-produto btn-sm">
                                    Editar
                                </a>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

    <footer class="text-center py-4">
        Vértice Watches - 2026
    </footer>

</body>
</html>
