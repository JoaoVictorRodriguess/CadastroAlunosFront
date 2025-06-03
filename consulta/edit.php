<?php
require_once '../banco/connect.php';

$role = $_SESSION['usuario_role'] ?? null; // evita erro caso não esteja logado

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: consulta.php?erro=sem_id");
    exit;
}

$stmt = $con->prepare("SELECT s.*, a.* FROM students s LEFT JOIN addresses a ON a.id = s.address_id WHERE s.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$aluno = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Aluno</title>
    <link rel="stylesheet" href="../cadastro/css/cadastro.css">
</head>
<body>
    <header>	
		<div class="cabecalho">
			<div class="logo">
				<img src="imagens/logo.png">
			</div><!--logo-->
			<div class="menu">
					<a href="../inicial/inicial.php">Inicial</a>
					<a href="../cadastro/cadastro.php">Cadastro</a>
					<a href="../consulta/consulta.php">Consulta</a>
					<a href="../calendario/calendario.php">Calendário</a>
					<a href="../fale-conosco/fale-conosco.php">Fale Conosco</a>
			</div>
			<div class="sair">
    			<a href="../index.html" class="btn-sair">SAIR</a>
			</div><!--sair-->
		</div><!--cabeçalho-->
		<div class="Banner"></div><!--Banner-->
	</header><!--Header-->
	<section>
		<div class="Dados">
			<div class="titulo">
					<label for="Dados Pessoais">Editar Aluno</label>
				</div>
    <form method="POST" action="atualizar.php">
      <div class="containerDados">
        <input type="hidden" name="id" value="<?= $aluno['id'] ?>">
        <input type="hidden" name="address_id" value="<?= $aluno['address_id'] ?>">
        <input type="text" name="nome" value="<?= htmlspecialchars($aluno['name']) ?>" required>
        <input type="text" name="cpf" value="<?= htmlspecialchars($aluno['cpf']) ?>" required>
        <input type="text" name="rg" value="<?= htmlspecialchars($aluno['rg']) ?>" required>
        <input type="text" name="cep" value="<?= htmlspecialchars($aluno['cep']) ?>" required>
        <input type="text" name="logradouro" value="<?= htmlspecialchars($aluno['place']) ?>">
        <input type="text" name="numero" value="<?= htmlspecialchars($aluno['number']) ?>">
        <input type="text" name="bairro" value="<?= htmlspecialchars($aluno['neighborhood']) ?>">
        <input type="text" name="cidade" value="<?= htmlspecialchars($aluno['city']) ?>">
        <input type="text" name="estado" value="<?= htmlspecialchars($aluno['state']) ?>">
        <br><br><button class="btn-proximo" type="submit">Salvar Alterações</button>
      </div>
    </form>
		</div><!--Dados-->
	</section>
	<script src="javascript/script.js"></script>
</body>
</html>
