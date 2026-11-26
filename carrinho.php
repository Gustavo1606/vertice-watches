
<?php
session_start();
require_once "config/conexao.php";

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = (int) ($_POST['produto_id'] ?? 0);

    if (isset($_POST['remover'])) {

        unset($_SESSION['carrinho'][$id]);

    } else {

        $quantidade = max(1, (int) ($_POST['quantidade'] ?? 1));

        $consulta = $conexao->prepare(
            "SELECT * FROM produtos WHERE id = ? AND ativo = 1"
        );

        $consulta->execute([$id]);
        $produto = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($produto && $produto['estoque'] > 0) {

            $atual = $_SESSION['carrinho'][$id] ?? 0;

            $_SESSION['carrinho'][$id] = min(
                $atual + $quantidade,
                $produto['estoque']
            );
        }
    }

    header("Location: carrinho.php");
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Carrinho - Vértice Watches</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>

    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="navbar-brand text-white fw-bold">
                VÉRTICE WATCHES
            </a>
        </div>
    </nav>

    <div class="container py-5">

        <h2 class="text-center mb-4">Meu Carrinho</h2>

        <?php if (empty($_SESSION['carrinho'])): ?>

            <p class="text-center">Seu carrinho está vazio.</p>

        <?php else: ?>

            <div class="table-responsive">

                <table class="table align-middle text-center">

                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Subtotal</th>
                            <th>Ação</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($_SESSION['carrinho'] as $id => $quantidade): ?>

                        <?php
                        $consulta = $conexao->prepare(
                            "SELECT * FROM produtos WHERE id = ?"
                        );

                        $consulta->execute([$id]);
                        $produto = $consulta->fetch(PDO::FETCH_ASSOC);

                        if (!$produto) {
                            continue;
                        }

                        $subtotal = $produto['preco'] * $quantidade;
                        $total += $subtotal;
                        ?>

                        <tr>
                            <td>
                                <img src="img/<?= htmlspecialchars($produto['imagem']) ?>"
                                     class="imagem-carrinho">

                                <p><?= htmlspecialchars($produto['nome']) ?></p>
                            </td>

                            <td>
                                R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                            </td>

                            <td><?= $quantidade ?></td>

                            <td>
                                R$ <?= number_format($subtotal, 2, ',', '.') ?>
                            </td>

                            <td>
                                <form method="post">

                                    <input type="hidden" name="produto_id"
                                           value="<?= $id ?>">

                                    <button name="remover"
                                            class="btn btn-outline-danger btn-sm">
                                        Remover
                                    </button>

                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                    </tbody>
                </table>

            </div>

            <h4 class="text-end mt-4">
                Total: R$ <?= number_format($total, 2, ',', '.') ?>
            </h4>

            <div class="text-end mb-3">
                <a href="finalizar.php" class="btn btn-produto">
                    Finalizar compra
                </a>
            </div>

        <?php endif; ?>

        <a href="index.php" class="btn btn-outline-secondary">
            Continuar comprando
        </a>

    </div>

    <footer class="text-center py-4">
        Vértice Watches - 2026
    </footer>

</body>
</html>
