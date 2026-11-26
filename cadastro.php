
<?php
require_once "config/conexao.php";

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if ($nome == "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($senha) < 6) {

        $mensagem = "Preencha os campos corretamente.";

    } else {

        $consulta = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
        $consulta->execute([$email]);

        if ($consulta->fetch()) {

            $mensagem = "Este email ja esta cadastrado.";

        } else {

            $senha = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nome, email, senha, tipo)
                    VALUES (?, ?, ?, 'cliente')";

            $consulta = $conexao->prepare($sql);
            $consulta->execute([$nome, $email, $senha]);

            $mensagem = "Cadastro realizado com sucesso!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro - Vértice Watches</title>

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

            <h2 class="text-center mb-4">Criar conta</h2>

            <?php if ($mensagem != ""): ?>

                <div class="alert alert-info">
                    <?= htmlspecialchars($mensagem) ?>
                </div>

            <?php endif; ?>

            <form method="post" onsubmit="return validarCadastro()">

                <label>Nome completo</label>
                <input type="text" name="nome"
                       class="form-control mb-3" required>

                <label>Email</label>
                <input type="email" name="email"
                       class="form-control mb-3" required>

                <label>Senha</label>
                <input type="password" name="senha"
                       class="form-control mb-3"
                       minlength="6" required>

                <button type="submit" class="btn btn-produto w-100">
                    Cadastrar
                </button>

            </form>

            <p class="text-center mt-3">
                Já possui uma conta?
                <a href="login.php">Entrar</a>
            </p>

            <a href="index.php" class="btn btn-outline-secondary w-100">
                Voltar à loja
            </a>

        </div>

    </div>

    <footer class="text-center py-4">
        Vértice Watches - 2026
    </footer>

    <script src="js/script.js"></script>

</body>
</html>
