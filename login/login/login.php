<?php
session_start();
require_once '../../banco/connect.php'; 

if (isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['role'])) {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $role = intval($_POST['role']);

    // Verifica se o e-mail existe
    $sql = "SELECT id, name, email, password, role, status FROM users WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if ($usuario['status'] == 0) {
            echo "<script>alert('Conta inativa. Entre em contato com o administrador.'); window.history.back();</script>";
        } elseif ($usuario['role'] !== $role) {
            echo "<script>alert('Perfil incorreto para este usuário.'); window.history.back();</script>";
        } elseif (password_verify($senha, $usuario['password'])) {
            // Login OK - cria sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['name'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_role'] = $usuario['role'];

            echo "<script>alert('Login realizado com sucesso!'); window.location.href = '../../inicial/inicial.php';</script>";
        } else {
            echo "<script>alert('Senha incorreta.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('E-mail não encontrado.'); window.history.back();</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Preencha todos os campos.'); window.history.back();</script>";
}
?>
