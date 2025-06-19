<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Simulação de utilizador registado
$utilizador = $_SESSION['utilizador'] ?? 'Joao Silva';
$id_utilizador = $_SESSION['id_utilizador'] ?? 1;

// Geração dos dados vindos da página de escolha
$dataReserva = date('Y-m-d');
$checkin = $_POST['checkin'] ?? '-';
$checkout = $_POST['checkout'] ?? '-';

$tipos = ['carro', 'aventura', 'relaxamento', 'gastronomia'];
$reservas = [];

foreach ($tipos as $tipo) {
  if (!empty($_POST[$tipo])) {
    $reservas[] = [
      'tipo' => strtoupper($tipo),
      'subtipo' => $_POST[$tipo],
      'checkin' => $_POST['checkin'] ?? '-',
      'checkout' => $_POST['checkout'] ?? '-',
      'reserva_id' => rand(1000, 9999),
      'data_reserva' => date('Y-m-d'),
      'pagamento' => 'Não'
    ];
  }
}

// Se nenhuma das opções foi escolhida, cria pelo menos 1 entrada com HOTEL
if (empty($reservas)) {
  $reservas[] = [
    'tipo' => 'HOTEL',
    'subtipo' => 'Check-in/out',
    'checkin' => $_POST['checkin'] ?? '-',
    'checkout' => $_POST['checkout'] ?? '-',
    'reserva_id' => rand(1000, 9999),
    'data_reserva' => date('Y-m-d'),
    'pagamento' => 'Nao'
  ];
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Gestao de Reservas</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eee;
      padding: 2rem;
    }
    h1 {
      text-align: center;
      margin-bottom: 2rem;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }
    th, td {
      padding: 1rem;
      border: 1px solid #ccc;
      text-align: center;
    }
    th {
      background: #007BFF;
      color: white;
    }
  </style>
</head>
<body>
  <h1>Gestao de Reservas</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Utilizador</th>
        <th>Reserva ID</th>
        <th>Data de Reserva</th>
        <th>Tipo</th>
        <th>Subtipo</th>
        <th>Check-in</th>
        <th>Check-out</th>
        <th>Pagamento</th>
      </tr>
    </thead>
        <tbody>
            <?php foreach ($reservas as $reserva): ?>
                <tr>
                    <td><?= $id_utilizador ?></td>
                    <td><?= htmlspecialchars($utilizador) ?></td>
                    <td><?= $reserva['reserva_id'] ?></td>
                    <td><?= $reserva['data_reserva'] ?></td>
                    <td><?= $reserva['tipo'] ?></td>
                    <td><?= $reserva['subtipo'] ?></td>
                    <td><?= $reserva['checkin'] ?></td>
                    <td><?= $reserva['checkout'] ?></td>
                    <td><?= $reserva['pagamento'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="text-align: center; margin-top: 2rem;">
      <button onclick="window.location.href='escolha_reservas2.html'" style="padding: 0.75rem 1.5rem; font-size: 1rem; background: #007BFF; color: white; border: none; border-radius: 6px; cursor: pointer;">
        CONTINUAR A ESCOLHER
      </button>
    </div>
</body>
</html>
