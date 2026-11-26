
<?php
require_once "config/conexao.php";

$id = (int) ($_GET['id'] ?? 0);

$sql = "SELECT * FROM produtos WHERE id = ? AND ativo = 1";
$consulta = $conexao->prepare($sql);
$consulta->execute([$id]);
$produto = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalhes - Vértice Watches</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>

    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="navbar-brand text-white fw-bold">
                VÉRTICE WATCHES
            </a>

            <a href="carrinho.php" class="text-white">
                Carrinho
            </a>
        </div>
    </nav>

    <div class="container py-5">

        <div class="row align-items-center">

            <div class="col-md-6 text-center">

                <img src="img/<?= htmlspecialchars($produto['imagem']) ?>"
                     class="imagem-detalhe"
                     alt="<?= htmlspecialchars($produto['nome']) ?>">

            </div>

            <div class="col-md-6">

                <h2><?= htmlspecialchars($produto['nome']) ?></h2>

                <p><?= htmlspecialchars($produto['descricao']) ?></p>

                <h3>
                    R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                </h3>

                <p>Estoque: <?= $produto['estoque'] ?></p>

                <?php if ($produto['estoque'] > 0): ?>

                    <form action="carrinho.php" method="post">

                        <input type="hidden" name="produto_id"
                               value="<?= $produto['id'] ?>">

                        <label>Quantidade:</label>

                        <input type="number" name="quantidade"
                               value="1" min="1"
                               max="<?= $produto['estoque'] ?>"
                               class="form-control w-25 mb-3" required>

                        <button type="submit" class="btn btn-produto">
                            Adicionar ao carrinho
                        </button>

                    </form>

                <?php else: ?>

                    <p>Produto sem estoque.</p>

                <?php endif; ?>

                <a href="index.php" class="btn btn-outline-secondary mt-3">
                    Voltar aos produtos
                </a>

            </div>

        </div>

    </div>

    <footer class="text-center py-4">
        Vértice Watches - 2026
    </footer>

</body>
</html>
