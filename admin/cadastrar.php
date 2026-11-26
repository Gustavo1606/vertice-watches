
<?php
session_start();
require_once "../config/conexao.php";

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$categorias = $conexao->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];
    $imagem = trim($_POST['imagem']);
    $categoria = (int) $_POST['categoria'];

    if ($nome == "" || !is_numeric($preco) || $preco <= 0 || filter_var($estoque, FILTER_VALIDATE_INT) === false || $estoque < 0) {

        $mensagem = "Preencha os campos corretamente.";

    } elseif ($imagem != basename($imagem) || !is_file("../img/" . $imagem)) {

        $mensagem = "Imagem não encontrada na pasta img.";

    } else {

        $sql = "INSERT INTO produtos
                (nome, descricao, preco, estoque, imagem, categoria_id, ativo)
                VALUES (?, ?, ?, ?, ?, ?, 1)";

        $consulta = $conexao->prepare($sql);

        $consulta->execute([
            $nome,
            $descricao,
            $preco,
            $estoque,
            $imagem,
            $categoria
        ]);

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar produto - Vértice Watches</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/estilo.css">
</head>

<body>

    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="navbar-brand text-white fw-bold">
                VÉRTICE WATCHES | ADMIN
            </a>
        </div>
    </nav>

    <div class="container py-5">

        <div class="formulario">

            <h2 class="text-center mb-4">Cadastrar produto</h2>

            <?php if ($mensagem != ""): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($mensagem) ?>
                </div>
            <?php endif; ?>

            <form method="post">

                <label>Nome do produto</label>
                <input type="text" name="nome"
                       class="form-control mb-3" required>

                <label>Descrição</label>
                <textarea name="descricao"
                          class="form-control mb-3" required></textarea>

                <label>Preço</label>
                <input type="number" name="preco"
                       step="0.01" min="0.01"
                       class="form-control mb-3" required>

                <label>Estoque</label>
                <input type="number" name="estoque"
                       min="0" class="form-control mb-3" required>

                <label>Nome da imagem</label>
                <input type="text" name="imagem"
                       placeholder="Exemplo: orient.jpg"
                       class="form-control mb-3" required>

                <label>Categoria</label>

                <select name="categoria" class="form-select mb-3" required>

                    <?php foreach ($categorias as $categoria): ?>

                        <option value="<?= $categoria['id'] ?>">
                            <?= htmlspecialchars($categoria['nome']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

                <button type="submit" class="btn btn-produto w-100">
                    Cadastrar produto
                </button>

            </form>

            <a href="index.php" class="btn btn-outline-secondary w-100 mt-3">
                Voltar ao painel
            </a>

        </div>

    </div>

    <footer class="text-center py-4">
        Vértice Watches - 2026
    </footer>

</body>
</html>
