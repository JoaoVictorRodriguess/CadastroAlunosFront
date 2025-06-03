<?php
require_once '../banco/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $address_id = $_POST['address_id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $cep = $_POST['cep'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    // Atualiza tabela students
    $stmt = $con->prepare("UPDATE students SET name=?, cpf=?, rg=? WHERE id=?");
    $stmt->bind_param("sssi", $nome, $cpf, $rg, $id);
    $stmt->execute();
    $stmt->close();

    // Atualiza tabela addresses
    $stmt = $con->prepare("UPDATE addresses SET cep=?, place=?, number=?, neighborhood=?, city=?, state=? WHERE id=?");
    $stmt->bind_param("ssisssi", $cep, $logradouro, $numero, $bairro, $cidade, $estado, $address_id);
    $stmt->execute();
    $stmt->close();

    header("Location: consulta.php?atualizado=1");
    exit;
} else {
    header("Location: consulta.php?erro=1");
    exit;
}
