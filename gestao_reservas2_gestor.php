<?php
session_start();

// Simulação: reservas estão guardadas na sessão
$reservas = $_SESSION['reservas'] ?? [];

// Marcar reserva como paga
if (isset($_GET['pagar']) && is_numeric($_GET['pagar'])) {
    $reserva_id = $_GET['pagar'];
    foreach ($reservas as &$reserva) {
        if ($reserva['reserva_id'] == $reserva_id) {
            $reserva['pagamento'] = 'Pago';
            break;
        }
    }
    $_SESSION['reservas'] = $reservas;
    // Redireciona para evitar reenvio
    header("Location: gestao_gestor.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Reservas - Gestor</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Reservas - Gestor</h2>
    <table>
        <thead>
            <tr>
                <th>ID Utilizador</th>
                <th>Utilizador</th>
                <th>Reserva ID</th>
                <th>Data de Reserva</th>
                <th>Tipo</th>
                <th>Subtipo</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Pagamento</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $reserva): ?>
                <tr>
                    <td><?= $id_utilizador ?? '-' ?></td>
                    <td><?= htmlspecialchars($utilizador ?? '-') ?></td>
                    <td><?= $reserva['reserva_id'] ?></td>
                    <td><?= $reserva['data_reserva'] ?></td>
                    <td><?= $reserva['tipo'] ?></td>
                    <td><?= $reserva['subtipo'] ?></td>
                    <td><?= $reserva['checkin'] ?></td>
                    <td><?= $reserva['checkout'] ?></td>
                    <td><?= $reserva['pagamento'] ?></td>
                    <td>
                        <?php if ($reserva['pagamento'] != 'Pago'): ?>
                            <a href="gestao_gestor.php?pagar=<?= $reserva['reserva_id'] ?>">Marcar como Pago</a>
                        <?php else: ?>
                            Pago
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

