<?php
session_start();

// 1. Ligação à base de dados
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "nome_da_base_dados";

$conn = new mysqli($servername, $username, $password, $dbname);

// 2. Receber dados do formulário
$reserva_id = $_POST['reserva_id'];
$metodo_pagamento = $_POST['metodo_pagamento']; // 'cartao' ou 'checkin'

// 3. Atualizar a reserva na base de dados
$sql = "UPDATE reservas SET pagamento = ? WHERE reserva_id = ?";
$stmt = $conn->prepare($sql);

// Mapear método para valor legível
$status_pagamento = ($metodo_pagamento == 'cartao') ? 'Pago com cartão' : 'Pagar no check-in';

$stmt->bind_param("si", $status_pagamento, $reserva_id);
$stmt->execute();

// 4. Redirecionar após sucesso
header("Location: gestao_reservas2.php?sucesso=1");
exit;
?>

