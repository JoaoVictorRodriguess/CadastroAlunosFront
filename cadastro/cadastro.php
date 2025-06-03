<?php
session_start();
require_once '../banco/connect.php';

$role = $_SESSION['usuario_role'] ?? null; // evita erro caso não esteja logado
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/cadastro.css">
	<title>Cadastro de Alunos</title>
</head>
<body>
	<header>	
		<div class="cabecalho">
			<div class="logo">
				<img src="imagens/logo.png">
			</div><!--logo-->
			<div class="menu">
					<a href="../inicial/inicial.php">Inicial</a>

					<?php if ($role != 0): // não-aluno ?>
							<a href="../cadastro/cadastro.php">Cadastro</a>
							<a href="../consulta/consulta.php">Consulta</a>
					<?php endif; ?>

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
			<form action="cadastro-action.php" method="POST" onsubmit="return validarSelects()">
				<div class="titulo">
					<label for="Dados Pessoais">Dados Pessoais</label>
				</div><!--titulo-->
				<div class="containerDados">
					<input type="text" id="nome" name="nome" value="" required placeholder="Nome">
					<input type="number" id="codmat" name="codmat" disabled="" placeholder="Código de Matrícula">
					<input type="date" id="data" name="data_nasc" value="" required placeholder="Data de Nascimento">
					<input type="text" id="cpf" name="cpf" value="" required oninput="this.value = formatarCPF(this.value)" placeholder="CPF" maxlength="14">
					<input type="text" id="rg" name="rg" value="" required oninput="this.value = formatarRG(this.value)" placeholder="RG" maxlength="12">
					<select name="sexo" id="sexo">
						<option value="" disabled selected>Gênero</option>
						<option>Masculino</option>
						<option>Feminino</option>
						<option>Não Informar</option>
					</select>
					<select name="ativo" id="situacao">
						<option value="" disabled selected>Situação</option>
						<option>Ativo</option>
						<option>Inativo</option>
						<option>Transferido</option>
					</select>
					<input type="radio" name="turno" id="turno" value="Manha">
					<label>Manha</label>
					<input type="radio" name="turno" id="turno" value="Tarde">
					<label>Tarde</label>
					<input type="text" name="telefone" id="telefone" required placeholder="Telefone Fixo">
					<input type="text" name="comercial" id="comercial" placeholder="Telefone Comercial">
					<input type="text" name="celular" id="celular" required placeholder="Celular">
					<select name="origem" id="origem">
						<option value="" disabled selected>Origem do Contato</option>
						<option value="Pai">Pai</option>
						<option value="Mae">Mãe</option>
						<option value="Irmao">Irmão/Irmã</option>
						<option value="Avo">Avô/Avó</option>
						<option value="Tio">Tio(a)</option>
						<option value="Outros">Outros</option>
					</select>
					<input type="text" name="opcao_outros" id="opcao" placeholder="Outros" disabled>
				</div><!--containerDados-->
				<div class="titulo">
					<label for="Endereco">Endereço</label>
				</div><!--titulos-->
				<div class="containerEndereco">
					<input type="text" name="cep" id="cep" required placeholder="CEP">
					<input type="text" name="logradouro" id="logradouro" placeholder="Logradouro">
					<input type="text" name="numero" id="numero" required placeholder="Número">
					<input type="text" name="comp" id="comp" placeholder="Complemento">
					<input type="text" name="bairro" id="bairro" required placeholder="Bairro">
					<input type="text" name="ref" id="ref" placeholder="Referência">
					<input type="text" name="cidade" id="cidade" required placeholder="Cidade">
					<select name="estado" id="estado">
						<option value="" disabled selected>Estado</option>
						<option>Acre</option>
						<option>Alagoas</option>
						<option>Amapá</option>
						<option>Amazonas</option>
						<option>Bahia</option>
						<option>Ceará</option>
						<option>Distrito Federal</option>
						<option>Espírito Santo</option>
						<option>Goiás</option>
						<option>Maranhão</option>
						<option>Mato Grosso</option>
						<option>Mato Grosso do Sul</option>
						<option>Minas Gerais</option>
						<option>Pará</option>
						<option>Paraíba</option>
						<option>Paraná</option>
						<option>Pernambuco</option>
						<option>Piauí</option>
						<option>Rio de Janeiro</option>
						<option>Rio Grande do Norte</option>
						<option>Rio Grande do Sul</option>
						<option>Rondônia</option>
						<option>Roraima</option>
						<option>Santa Catarina</option>
						<option>São Paulo</option>
						<option>Sergipe</option>
						<option>Tocantins</option>
					</select><!--Estado-->
				<div class="turma">
					<label for="turma">Turma</label>
				</div><!--turma-->
					<input type="text" id="professor" value="" placeholder="Professor" readonly>
					<select name="turma" id="turma">
						<option value=""disabled selected>Turma</option>
						<option value="1">1º Ano</option>
						<option value="2">2º Ano</option>
						<option value="3">3º Ano</option>
						<option value="4">4º Ano</option>
						<option value="5">5º Ano</option>
						<option value="6">6º Ano</option>
					</select><!--turma-->
					<textarea placeholder="Possui alguma observação?(opcional)"></textarea>
					<div class="submit">
						<button type="submit" class="btn-proximo"name="acao" value="Enviar">Enviar</button>
						<button type="submit" class="btn-proximo"name="acao" value="Cancelar">Cancelar</button>
					</div><!--submit-->
				</div><!--containerEndereco-->
			</form><!--form-->
		</div><!--Dados-->
	</section>
	<script src="javascript/script.js"></script>
</body>
</html>