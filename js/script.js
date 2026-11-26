function validarCadastro() {

    let senha = document.querySelector('[name="senha"]').value;

    if (senha.length < 6) {
        alert("A senha deve ter pelo menos 6 caracteres.");
        return false;
    }

    return true;
}

function confirmarCompra() {

    return confirm("Deseja confirmar sua compra?");
}
