
<?php
session_start();
require_once "config/conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if (empty($_SESSION['carrinho'])) {
    header("Location: carrinho.php");
    exit;
}

$total = 0;
$itens = [];
$mensagem = "";

foreach ($_SESSION['carrinho'] as $id => $quantidade) {

    $consulta = $conexao->prepare(
        "SELECT * FROM produtos WHERE id = ?"
    );

    $consulta->execute([$id]);
    $produto = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($produto) {
        $produto['quantidade'] = $quantidade;
        $itens[] = $produto;
        $total += $produto['preco'] * $quantidade;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $pagamento = $_POST['pagamento'] ?? '';

    if (in_array($pagamento, ['Pix', 'Cartão de crédito', 'Boleto'])) {

        try {

            $conexao->beginTransaction();

            $total = 0;
            $itens = [];

            foreach ($_SESSION['carrinho'] as $id => $quantidade) {

                $consulta = $conexao->prepare(
                    "SELECT * FROM produtos
                     WHERE id = ? AND ativo = 1 FOR UPDATE"
                );

                $consulta->execute([$id]);
                $produto = $consulta->fetch(PDO::FETCH_ASSOC);

                if (!$produto || $quantidade < 1 || $produto['estoque'] < $quantidade) {
                    throw new Exception("Produto indisponível ou estoque insuficiente.");
                }

                $produto['quantidade'] = $quantidade;
                $itens[] = $produto;
                $total += $produto['preco'] * $quantidade;
            }

            $sql = "INSERT INTO pedidos
                    (usuario_id, pagamento, total)
                    VALUES (?, ?, ?)";

            $consulta = $conexao->prepare($sql);

            $consulta->execute([
                $_SESSION['usuario_id'],
                $pagamento,
                $total
            ]);

            $pedido_id = $conexao->lastInsertId();

            foreach ($itens as $item) {

                $sql = "INSERT INTO itens_pedido
                        (pedido_id, produto_id, quantidade, preco_unitario)
                        VALUES (?, ?, ?, ?)";

                $consulta = $conexao->prepare($sql);

                $consulta->execute([
                    $pedido_id,
                    $item['id'],
                    $item['quantidade'],
                    $item['preco']
                ]);

                $sql = "UPDATE produtos
                        SET estoque = estoque - ?
                        WHERE id = ?";

                $consulta = $conexao->prepare($sql);

                $consulta->execute([
                    $item['quantidade'],
                    $item['id']
                ]);
            }

            $conexao->commit();

            unset($_SESSION['carrinho']);

            $_SESSION['pedido_realizado'] = $pedido_id;

            header("Location: sucesso.php");
            exit;

        } catch (Exception $e) {

            if ($conexao->inTransaction()) {
                $conexao->rollBack();
            }

            $mensagem = "Não foi possível finalizar o pedido. Confira o estoque.";
        }
    } else {
        $mensagem = "Selecione uma forma de pagamento.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Finalizar compra - Vértice Watches</title>

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

        <div class="formulario">

            <h2 class="text-center mb-4">Finalizar compra</h2>

            <p>Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!</p>

            <?php if ($mensagem != ""): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($mensagem) ?>
                </div>
            <?php endif; ?>

            <h5>Resumo do pedido</h5>

            <?php foreach ($itens as $item): ?>

                <p>
                    <?= htmlspecialchars($item['nome']) ?>
                    - <?= $item['quantidade'] ?> unidade(s)
                </p>

            <?php endforeach; ?>

            <hr>

            <h5>Total: R$ <?= number_format($total, 2, ',', '.') ?></h5>

            <form method="post" onsubmit="return confirmarCompra()">

                <label class="mt-3">Forma de pagamento</label>

                <select name="pagamento" class="form-select mb-3" required>

                    <option value="">Selecione</option>
                    <option value="Pix">Pix</option>
                    <option value="Cartão de crédito">Cartão de crédito</option>
                    <option value="Boleto">Boleto</option>

                </select>

                <button type="submit" class="btn btn-produto w-100">
                    Confirmar compra
                </button>

            </form>

            <a href="carrinho.php" class="btn btn-outline-secondary w-100 mt-3">
                Voltar ao carrinho
            </a>

        </div>

    </div>

    <footer class="text-center py-4">
        Vértice Watches - 2026
    </footer>

    <script src="js/script.js"></script>

</body>
</html>
