<?php
require_once "config/conexao.php";

$categorias = $conexao->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);

$categoria = (int) ($_GET['categoria'] ?? 0);

if ($categoria > 0) {
    $sql = "SELECT * FROM produtos WHERE ativo = 1 AND categoria_id = ?";
    $consulta = $conexao->prepare($sql);
    $consulta->execute([$categoria]);
} else {
    $sql = "SELECT * FROM produtos WHERE ativo = 1";
    $consulta = $conexao->query($sql);
}

$produtos = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vértice Watches</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>

    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="index.php">
                VÉRTICE WATCHES
            </a>

           
<div>
    <a href="#produtos" class="text-white me-3">Produtos</a>

    <a href="carrinho.php" class="text-white me-3">Carrinho</a>

    <?php if (isset($_SESSION['usuario_id'])): ?>

        <span class="text-white me-3">
            Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>
        </span>

        <a href="sair.php" class="text-white">Sair</a>

    <?php else: ?>

        <a href="login.php" class="text-white me-3">Entrar</a>

        <a href="cadastro.php" class="text-white">Cadastrar</a>

    <?php endif; ?>
</div>

        </div>
    </nav>

    <section class="banner text-center">
        <h1>Seu tempo. Seu estilo.</h1>
        <p>Relógios para todos os momentos.</p>
        <a href="#produtos" class="btn">Ver produtos</a>
    </section>

    <section class="container py-5" id="produtos">

        <h2 class="text-center mb-4">Nossos Relógios</h2>
        <div class="text-center mb-4">

    <a href="index.php#produtos" class="btn btn-produto m-1">
        Todos
    </a>

    <?php foreach ($categorias as $cat): ?>

        <a href="index.php?categoria=<?= $cat['id'] ?>#produtos"
           class="btn btn-produto m-1">

            <?= htmlspecialchars($cat['nome']) ?>

        </a>

    <?php endforeach; ?>

</div>

        <div class="row">

            <?php foreach ($produtos as $produto): ?>

                <div class="col-md-4 mb-4">

                    <div class="card h-100 text-center">

                        <img src="img/<?= htmlspecialchars($produto['imagem']) ?>"
                             class="card-img-top"
                             alt="<?= htmlspecialchars($produto['nome']) ?>">

                        <div class="card-body">

                            <h5 class="card-title">
                                <?= htmlspecialchars($produto['nome']) ?>
                            </h5>

                            <p>
                                R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                            </p>

                            <p>
                                Estoque: <?= $produto['estoque'] ?>
                            </p>

                            <a href="produto.php?id=<?= $produto['id'] ?>"
                               class="btn btn-produto">
                                Ver detalhes
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </section>

    <footer class="text-center py-4">
        Vértice Watches - 2026
    </footer>

</body>
</html>
