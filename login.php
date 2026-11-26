
<?php
session_start();
require_once "config/conexao.php";

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $consulta = $conexao->prepare($sql);
    $consulta->execute([$email]);

    $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {

        session_regenerate_id(true);

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];

        header("Location: index.php");
        exit;

    } else {

        $mensagem = "Email ou senha incorretos!";

    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Vértice Watches</title>

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

            <h2 class="text-center mb-4">Entrar</h2>

            <?php if ($mensagem != ""): ?>

                <div class="alert alert-danger">
                    <?= htmlspecialchars($mensagem) ?>
                </div>

            <?php endif; ?>

            <form method="post">

                <label>Email</label>
                <input type="email" name="email"
                       class="form-control mb-3" required>

                <label>Senha</label>
                <input type="password" name="senha"
                       class="form-control mb-3" required>

                <button type="submit" class="btn btn-produto w-100">
                    Entrar
                </button>

            </form>

            <p class="text-center mt-3">
                Ainda não possui uma conta?
                <a href="cadastro.php">Cadastre-se</a>
            </p>

            <a href="index.php" class="btn btn-outline-secondary w-100">
                Voltar à loja
            </a>

        </div>

    </div>

    <footer class="text-center py-4">
        Vértice Watches - 2026
    </footer>

</body>
</html>
