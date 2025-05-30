<?php
$conn = new PDO('mysql:host=localhost;dbname=school', 'usuario', 'senha');

$stmt = $conn->query("SELECT nome, cpf, classe, endereco FROM students");
$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($registros);
?>