<?php
require_once '../banco/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // DADOS PESSOAIS
    $nome = $_POST['nome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $rg = $_POST['rg'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $situacao = $_POST['ativo'] ?? '';
    $periodo = $_POST['turno'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $telefoneComercial = $_POST['comercial'] ?? '';
    $celular = $_POST['celular'] ?? '';
    $contatoOrig = $_POST['origem'] ?? '';

    // ENDEREÇO
    $cep = $_POST['cep'] ?? '';
    $logradouro = $_POST['logradouro'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $complemento = $_POST['comp'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $referencia = $_POST['ref'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $estado = $_POST['estado'] ?? '';

    // INSERT na tabela addresses
    $stmt = $con->prepare("INSERT INTO addresses (cep, place, number, complement, neighborhood, reference, city, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssss", $cep, $logradouro, $numero, $complemento, $bairro, $referencia, $cidade, $estado);
    $stmt->execute();
    $address_id = $stmt->insert_id;
    $stmt->close();

    // INSERT direto na tabela students com nome incluído
    $ra = rand(1000000, 9999999); // RA aleatório

    $stmt = $con->prepare("INSERT INTO students (name, cpf, rg, ra, sex, situation, period, phone, comm_phone, cellphone, contact_orig, address_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisssssisi", $nome, $cpf, $rg, $ra, $sexo, $situacao, $periodo, $telefone, $telefoneComercial, $celular, $contatoOrig, $address_id);
    $stmt->execute();
    $stmt->close();

    header("Location: cadastro.php?sucesso=1");
    exit;
} else {
    header("Location: cadastro.php?erro=1");
    exit;
}
?>
