<?php
require_once '../../banco/connect.php'; 

if (isset($_POST['email'])&& isset($_POST['nova_senha']) && isset($_POST['confirma_senha'])) {
    $email = trim($_POST['email']);
    $nova_senha = $_POST['nova_senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if (empty($email) || empty($nova_senha) || empty($confirma_senha)) {
        echo "<script>alert('Preencha todos os campos.'); window.history.back();</script>";
        exit;
    }

    if ($nova_senha !== $confirma_senha) {
        echo "<script>alert('As senhas não coincidem.'); window.history.back();</script>";
        exit;
    }

    // Verifica se o e-mail existe
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        // Atualiza a senha
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $update = $con->prepare("UPDATE users SET password = ?, rst_password = 0 WHERE email = ?");
        $update->bind_param("ss", $senha_hash, $email);

        if ($update->execute()) {
            echo "<script>alert('Senha atualizada com sucesso!'); window.location.href = '../../index.html';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar senha.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('E-mail não encontrado.'); window.history.back();</script>";
    }

    $stmt->close();
}
?>
