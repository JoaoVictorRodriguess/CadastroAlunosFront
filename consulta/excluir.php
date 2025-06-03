<?php
require_once '../banco/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $student_id = intval($_POST['id']);

    // Primeiro busca o address_id do aluno
    $stmt = $con->prepare("SELECT address_id FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->bind_result($address_id);
    $stmt->fetch();
    $stmt->close();

    // Exclui o aluno da tabela students
    $stmt = $con->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->close();

    // Se address_id for válido, exclui também da tabela addresses
    if (!empty($address_id)) {
        $stmt = $con->prepare("DELETE FROM addresses WHERE id = ?");
        $stmt->bind_param("i", $address_id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: consulta.php?excluido=1");
    exit;
} else {
    header("Location: consulta.php?erro=1");
    exit;
}
