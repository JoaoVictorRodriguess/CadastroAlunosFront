<?php
session_start();
require_once '../banco/connect.php';

$role = $_SESSION['usuario_role'] ?? null; // evita erro caso não esteja logado

// Total de alunos
$result = $con->query("SELECT COUNT(*) AS total FROM students");
$total_alunos = $result->fetch_assoc()['total'];

// Total de salas
$result = $con->query("SELECT COUNT(DISTINCT id) AS total FROM classes");
$total_salas = $result->fetch_assoc()['total'];

// Total de professores
$result = $con->query("SELECT COUNT(*) AS total FROM users WHERE role = 1");
$total_professores = $result->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/inicial.css">
	<title>Pagina Inicial</title>
</head>
<body>
	<header>
		<div class="cabecalho">
			<div class="logo">
				<img src="imagens/logo.png">
			</div><!--logo-->
			<div class="menu">
					<a href="inicial.php">Inicial</a>

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
			<div class="cards">
				<div class="card1">
					<div class="card-conteudo">
						<span class="contador"><?= $total_alunos ?></span>
						<span class="descricao">Total de alunos</span>
					</div><!--card1-->
				</div><!--card-conteudo-->
				<div class="card2">
					<div class="card-conteudo">
						<span class="contador">10</span>
						<span class="descricao">Total de salas</span>
					</div><!--card2-->
				</div><!--card-conteudo-->
				<div class="card3">
					<div class="card-conteudo">
						<span class="contador">8</span>
						<span class="descricao">Total de matérias</span>
					</div><!--card3-->
				</div><!--card-conteudo-->
				<div class="card4">
					<div class="card-conteudo">
						<span class="contador"><?= $total_professores ?></span>
						<span class="descricao">Total de professores</span>
					</div><!--card4-->
				</div><!--card-conteudo-->
			</div><!--cards-->
			<div class="containerConteudo">
				<div class="conteudo">
					<h1>Ultimas Notícias</h1>
					<div class="noticias">
						<h2>Professores municipais de SP decidem continuar greve</h2><br>
						<h4>Categoria se opõe a reajuste abaixo da inflação</h4>
						<img src="imagens/professores.jpeg"><br>
						<p>Professores municipais ocuparam nesta terça-feira (22) o Viaduto do Chá, em frente à sede da prefeitura de São Paulo, e realizaram assembleia na qual aprovaram a continuidade da greve da categoria, iniciada no dia 15 de abril.
						Os profissionais da educação decretaram greve na semana passada, após rejeitarem a proposta do governo municipal de reajuste anual de 2,6%, a partir de 1º de maio de 2025, e de 2,55%, a partir de 1º de maio de 2026.
						A manifestação teve início no final da manhã, e, depois, os professores se dirigiram à Avenida Paulista, onde permaneceram até as 15h. O ato unificou os sindicatos que representam os cerca de 70 mil profissionais, que reivindicam que o reajuste dos salários não seja inferior à inflação anual acumulada.
						Além disso, os servidores municipais cobram: A incorporação aos salários dos 44% pagos como abono complementar de pisos salariais para ativos e aposentados da educação;
						o fim dos 14% de contribuição previdenciária, considerada desproporcional pela categoria;
						a redução de jornada de trabalho para profissionais de outras categorias da educação, como inspetores e merendeiras; e melhores condições de prevenção à saúde.
						A prefeitura ingressou na Justiça com ação para a instalação de dissídio coletivo de greve, com pedido de liminar, concedida pelo Tribunal de Justiça de São Paulo (TJ-SP). O juízo determinou o funcionamento das escolas com pelo menos 70% dos profissionais de educação, com pena de multa diária de R$10 mil para cada sindicato envolvido na greve.
						A categoria deve se mobilizar novamente na quarta-feira (23), quando a proposta salarial da prefeitura tem previsão de avaliação na Câmara dos Vereadores, onde há possibilidade de votação em sessão extraordinária. Nova assembleia foi convocada para quinta-feira, também na sede do legislativo paulistano.</p>
					</div><!--noticias-->
				</div><!--conteudo-->
				<div class="atalhos">
					<?php if ($role != 0): ?>
							<div class="atalho1">
									<a href="../cadastro/cadastro.php">
											<p>Cadastro de Alunos</p>
											<img src="imagens/adicao.png" class="transparente" alt="Adicionar">
									</a>
							</div>
							<div class="atalho2">
									<a href="../cadastro/cadastro.php">
											<p>Cadastrar Funcionários</p>
											<img src="imagens/adicao.png" alt="Adicionar">
									</a>
							</div>
							<div class="atalho3">
									<a href="../consulta/consulta.php">
											<p>Consultar Alunos</p>
											<img src="imagens/lupa.png" alt="Adicionar">
									</a>
							</div>
					<?php endif; ?>

					<div class="atalho4">
							<a href="../fale-conosco/fale-conosco.php">
									<p>Calendário Acadêmico</p>
									<img src="imagens/calendario.png" alt="Calendário">
							</a>
					</div>
			</div>
			</div><!--conteudo-e-atalhos-->
		</div><!--dados-->
	</section>
</body>
</html>