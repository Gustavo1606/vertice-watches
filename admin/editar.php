
<?php
session_start();
require_once "../config/conexao.php";

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = (int) ($_GET['id'] ?? 0);

$consulta = $conexao->prepare("SELECT * FROM produtos WHERE id = ?");
$consulta->execute([$id]);
$produto = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
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
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    if ($nome == "" || !is_numeric($preco) || $preco <= 0 || filter_var($estoque, FILTER_VALIDATE_INT) === false || $estoque < 0) {

        $mensagem = "Preencha os campos corretamente.";

    } elseif ($imagem != basename($imagem) || !is_file("../img/" . $imagem)) {

        $mensagem = "Imagem não encontrada.";

    } else {

        $sql = "UPDATE produtos SET
                nome = ?,
                descricao = ?,
                preco = ?,
                estoque = ?,
                imagem = ?,
                categoria_id = ?,
                ativo = ?
                WHERE id = ?";

        $consulta = $conexao->prepare($sql);

        $consulta->execute([
            $nome,
            $descricao,
            $preco,
            $estoque,
            $imagem,
            $categoria,
            $ativo,
            $id
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

    <title>Editar produto - Vértice Watches</title>

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

            <h2 class="text-center mb-4">Editar produto</h2>

            <?php if ($mensagem != ""): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($mensagem) ?>
                </div>
            <?php endif; ?>

            <form method="post">

                <label>Nome do produto</label>

                <input type="text" name="nome"
                       value="<?= htmlspecialchars($produto['nome']) ?>"
                       class="form-control mb-3" required>

                <label>Descrição</label>

                <textarea name="descricao"
                          class="form-control mb-3" required><?= htmlspecialchars($produto['descricao']) ?></textarea>

                <label>Preço</label>

                <input type="number" name="preco"
                       value="<?= $produto['preco'] ?>"
                       step="0.01" min="0.01"
                       class="form-control mb-3" required>

                <label>Estoque</label>

                <input type="number" name="estoque"
                       value="<?= $produto['estoque'] ?>"
                       min="0"
                       class="form-control mb-3" required>

                <label>Nome da imagem</label>

                <input type="text" name="imagem"
                       value="<?= htmlspecialchars($produto['imagem']) ?>"
                       class="form-control mb-3" required>

                <label>Categoria</label>

                <select name="categoria" class="form-select mb-3">

                    <?php foreach ($categorias as $categoria): ?>

                        <option value="<?= $categoria['id'] ?>"
                            <?= $categoria['id'] == $produto['categoria_id'] ? 'selected' : '' ?>>

                            <?= htmlspecialchars($categoria['nome']) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

                <div class="form-check mb-3">

                    <input type="checkbox" name="ativo"
                           id="ativo" class="form-check-input"
                           <?= $produto['ativo'] ? 'checked' : '' ?>>

                    <label for="ativo" class="form-check-label">
                        Produto ativo
                    </label>

                </div>

                <button type="submit" class="btn btn-produto w-100">
                    Salvar alterações
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
