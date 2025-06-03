<?php
session_start();
require_once '../banco/connect.php';

$role = $_SESSION['usuario_role'] ?? null;

// Processar busca
$nome = $_GET['nome'] ?? '';
$cpf = $_GET['cpf'] ?? '';
$rg = $_GET['rg'] ?? '';
$turma = $_GET['turma'] ?? '';
$situacao = $_GET['situacao'] ?? '';

$where = [];

if ($nome) $where[] = "s.name LIKE '%" . $con->real_escape_string($nome) . "%'";
if ($cpf) $where[] = "s.cpf LIKE '%" . $con->real_escape_string($cpf) . "%'";
if ($rg) $where[] = "s.rg LIKE '%" . $con->real_escape_string($rg) . "%'";
if ($turma) $where[] = "c.title = '" . $con->real_escape_string($turma) . "'";
if ($situacao && $situacao !== 'Todos') $where[] = "s.situation = '" . $con->real_escape_string($situacao) . "'";

$whereClause = count($where) ? "WHERE " . implode(" AND ", $where) : "";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consulta de Alunos</title>
    <link rel="stylesheet" href="css/consulta.css">
</head>
<body>
    <header>
        <div class="cabecalho">
            <div class="logo">
                <img src="imagens/logo.png">
            </div>
            <div class="menu">
                <a href="../inicial/inicial.php">Inicial</a>
                <?php if ($role != 0): ?>
                    <a href="../cadastro/cadastro.php">Cadastro</a>
                    <a href="../consulta/consulta.php">Consulta</a>
                <?php endif; ?>
                <a href="../calendario/calendario.php">Calendário</a>
                <a href="../fale-conosco/fale-conosco.php">Fale Conosco</a>
            </div>
            <div class="sair">
                <a href="../index.html" class="btn-sair">SAIR</a>
            </div>
        </div>
        <div class="Banner"></div>
    </header>

    <section>
        <div class="Dados">
            <form method="GET">
                <div class="titulo">
                    <label>Consulta de Alunos</label>
                </div>
                <div class="containerFiltros">
                    <input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>" placeholder="Nome">
                    <input type="text" name="cpf" value="<?= htmlspecialchars($cpf) ?>" placeholder="CPF">
                    <input type="text" name="rg" value="<?= htmlspecialchars($rg) ?>" placeholder="RG">
                    <select name="turma">
                        <option value="">Turma</option>
                        <?php
                        $turmas = $con->query("SELECT DISTINCT title FROM classes");
                        while ($t = $turmas->fetch_assoc()) {
                            $selected = $turma == $t['title'] ? "selected" : "";
                            echo "<option value='{$t['title']}' $selected>{$t['title']}</option>";
                        }
                        ?>
                    </select>
                    <select name="situacao">
                        <option value="" <?= $situacao === '' ? 'selected' : '' ?>>Situação</option>
                        <option value="Ativo" <?= $situacao === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
                        <option value="Inativo" <?= $situacao === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
                        <option value="Todos" <?= $situacao === 'Todos' ? 'selected' : '' ?>>Todos</option>
                    </select>
                    <div class="submit">
                        <button type="submit" class="btn-proximo">Buscar</button>
                        <button type="button" class="btn-proximo" onclick="window.location.href='consulta.php'">Limpar</button>

                    </div>
                </div>
            </form>

            <div class="containerTable">
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th style="width = 400px;">CPF</th>
                            <th>Classe</th>
                            <th>Endereço</th>
                            <th>Excluir</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT 
                                    s.id,
                                    s.name,
                                    s.cpf,
                                    c.title AS classe,
                                    CONCAT_WS(', ', a.place, a.number, a.neighborhood) AS endereco
                                FROM students s
                                LEFT JOIN users u ON u.id = s.user_id
                                LEFT JOIN addresses a ON a.id = s.address_id
                                LEFT JOIN classes c ON c.student_id = s.id
                                $whereClause";

                        $res = $con->query($sql);
                        if ($res && $res->num_rows > 0):
                            while ($row = $res->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['cpf']) ?></td>
                            <td><?= htmlspecialchars($row['classe']) ?></td>
                            <td><?= htmlspecialchars($row['endereco']) ?></td>
                            <td>
                                <form method="POST" action="excluir.php" onsubmit="return confirm('Deseja realmente excluir?')">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <input type="submit" class="btn-excluir" value="Excluir">
                                </form>
                            </td>
                            <td><a href="edit.php?id=<?= $row['id'] ?>" class="btn-editar">Editar</a></td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="6">Nenhum aluno encontrado.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
