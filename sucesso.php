
<?php
session_start();

if (!isset($_SESSION['pedido_realizado'])) {
    header("Location: index.php");
    exit;
}

$pedido = $_SESSION['pedido_realizado'];
unset($_SESSION['pedido_realizado']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <title>Pedido realizado - Vértice Watches</title>

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

        <div class="formulario text-center">

            <h2>Pedido realizado com sucesso!</h2>

            <p>Número do pedido: <?= $pedido ?></p>

            <p>Obrigado por comprar na Vértice Watches.</p>

            <a href="index.php" class="btn btn-produto">
                Voltar à loja
            </a>

        </div>

    </div>

    <footer class="text-center py-4">
        Vértice Watches - 2026
    </footer>

</body>
</html>
