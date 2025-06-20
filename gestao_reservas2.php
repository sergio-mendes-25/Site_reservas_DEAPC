<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Verifica se o utilizador está autenticado
if (!isset($_SESSION['id_utilizador'], $_SESSION['utilizador'])) {
  die("Acesso negado. Por favor inicie sessão.");
}

$id_utilizador = $_SESSION['id_utilizador'];
$utilizador = $_SESSION['utilizador'];

// Ligação à base de dados
$db = new SQLite3('scripts/hotel.db');

// Apagar reservas se o utilizador clicar em "cancelar"
if (isset($_POST['cancelar'])) {
  $stmt = $db->prepare("DELETE FROM reservas WHERE id_utilizador = :id");
  $stmt->bindValue(':id', $id_utilizador, SQLITE3_INTEGER);
  $stmt->execute();

  header("Location: escolha_reservas2.html");
  exit;
}

// Criação da tabela reservas (se necessário)
$db->exec("CREATE TABLE IF NOT EXISTS reservas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_utilizador INTEGER,
    reserva_id INTEGER,
    data_reserva TEXT,
    tipo TEXT,
    subtipo TEXT,
    checkin TEXT,
    checkout TEXT,
    pagamento TEXT
)");

// Inserção de nova reserva (se vier de POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['cancelar'])) {
  $tipos = ['carro', 'aventura', 'relaxamento', 'gastronomia'];
  foreach ($tipos as $tipo) {
    if (!empty($_POST[$tipo])) {
      $stmt = $db->prepare("INSERT INTO reservas (id_utilizador, reserva_id, data_reserva, tipo, subtipo, checkin, checkout, pagamento)
                            VALUES (:id_utilizador, :reserva_id, :data_reserva, :tipo, :subtipo, :checkin, :checkout, :pagamento)");
      $stmt->bindValue(':id_utilizador', $id_utilizador, SQLITE3_INTEGER);
      $stmt->bindValue(':reserva_id', rand(1000, 9999), SQLITE3_INTEGER);
      $stmt->bindValue(':data_reserva', date('Y-m-d'), SQLITE3_TEXT);
      $stmt->bindValue(':tipo', strtoupper($tipo), SQLITE3_TEXT);
      $stmt->bindValue(':subtipo', $_POST[$tipo], SQLITE3_TEXT);
      $stmt->bindValue(':checkin', $_POST['checkin'] ?? '-', SQLITE3_TEXT);
      $stmt->bindValue(':checkout', $_POST['checkout'] ?? '-', SQLITE3_TEXT);
      $stmt->bindValue(':pagamento', 'Não', SQLITE3_TEXT);
      $stmt->execute();
    }
  }

  // Caso nenhum tipo tenha sido selecionado, regista como HOTEL
  if (empty(array_filter($_POST, fn($v, $k) => in_array($k, $tipos) && !empty($v), ARRAY_FILTER_USE_BOTH))) {
    $stmt = $db->prepare("INSERT INTO reservas (id_utilizador, reserva_id, data_reserva, tipo, subtipo, checkin, checkout, pagamento)
                          VALUES (:id_utilizador, :reserva_id, :data_reserva, :tipo, :subtipo, :checkin, :checkout, :pagamento)");
    $stmt->bindValue(':id_utilizador', $id_utilizador, SQLITE3_INTEGER);
    $stmt->bindValue(':reserva_id', rand(1000, 9999), SQLITE3_INTEGER);
    $stmt->bindValue(':data_reserva', date('Y-m-d'), SQLITE3_TEXT);
    $stmt->bindValue(':tipo', 'HOTEL', SQLITE3_TEXT);
    $stmt->bindValue(':subtipo', 'Check-in/out', SQLITE3_TEXT);
    $stmt->bindValue(':checkin', $_POST['checkin'] ?? '-', SQLITE3_TEXT);
    $stmt->bindValue(':checkout', $_POST['checkout'] ?? '-', SQLITE3_TEXT);
    $stmt->bindValue(':pagamento', 'Não', SQLITE3_TEXT);
    $stmt->execute();
  }
}

// Carregar todas as reservas do utilizador da base de dados
$reservas = [];
$result = $db->prepare("SELECT * FROM reservas WHERE id_utilizador = :id");
$result->bindValue(':id', $id_utilizador, SQLITE3_INTEGER);
$res = $result->execute();

while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
  $reservas[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Gestão de Reservas</title>
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f2f2f2;
    }

    header {
      background-color: #003366;
      color: white;
      padding: 20px;
      text-align: center;
    }

    h1 {
      margin: 0;
    }

    table {
      width: 90%;
      margin: 20px auto;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }

    th {
      background-color: #003366;
      color: white;
    }

    .botoes {
      text-align: center;
      margin: 30px;
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .botoes button {
      padding: 12px 24px;
      font-size: 16px;
      background-color: #003366;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    .botoes .cancelar {
      background-color: #cc0000;
    }
  </style>
</head>
<body>
  <header>
    <h1>Gestão de Reservas</h1>
  </header>

  <main>
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

    <div class="botoes">
      <form method="get" action="escolha_reservas2.html">
        <button type="submit">CONTINUAR A ESCOLHER</button>
      </form>

      <form method="post" action="">
        <button type="submit" name="cancelar" class="cancelar">CANCELAR RESERVA</button>
      </form>
    </div>
  </main>
</body>
</html>
