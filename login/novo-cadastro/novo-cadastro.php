<?php
require_once '../../banco/connect.php';

if (isset($_POST['criar_conta'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if (empty($nome) || empty($email) || empty($senha) || empty($confirma_senha)) {
        echo "<script>
                alert('Preencha todos os campos obrigatórios.');
                window.history.back();
              </script>";
    } elseif ($senha !== $confirma_senha) {
        echo "<script>
                alert('As senhas não coincidem.');
                window.history.back();
              </script>";
    } else {
        // Verifica se o e-mail já existe
        $check = $con->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo "<script>
                    alert('Este e-mail já está cadastrado.');
                    window.history.back();
                  </script>";
        } else {
            // Inserir usuário
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $status = 1;
            $rst_password = 0;
            $role = 1;

            $sql = "INSERT INTO users (name, email, password, status, rst_password, role) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sssiii", $nome, $email, $senha_hash, $status, $rst_password, $role);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Cadastro realizado com sucesso!');
                        window.location.href = '../../index.html';
                      </script>";
            } else {
                echo "<script>
                        alert('Erro ao cadastrar: " . addslashes($con->error) . "');
                        window.history.back();
                      </script>";
            }
        }

        $check->close();
    }
}
?>
