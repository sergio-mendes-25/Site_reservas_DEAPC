<?php
// Iniciar sessão para guardar estado do utilizador
session_start();

// Abrir base de dados SQLite
$db = new SQLite3('../database/hotel.db');

// Receber dados do formulário (via POST)
$email = $_POST['email'] ?? '';
$password = $_POST['pass'] ?? '';

// Preparar query para procurar utilizador pelo email
$stmt = $db->prepare('SELECT * FROM users WHERE Email = :email');
$stmt->bindValue(':email', $email, SQLITE3_TEXT);
$result = $stmt->execute();

// Obter utilizador
$user = $result->fetchArray(SQLITE3_ASSOC);

// Verificar se utilizador existe e se password está correta
if ($user && password_verify($password, $user['Password'])) {
    // Guardar dados na sessão
    $_SESSION['id_utilizador'] = $user['ID'];        // <- necessário para gestao_reservas.php
    $_SESSION['email'] = $user['Email'];
    $_SESSION['nome'] = $user['Nome'];
    $_SESSION['utilizador'] = $user['Nome'];         // <- também usado na tabela

    // Redirecionar para a área reservada do cliente
    header('Location: /~sergio/Site_reservas_DEAPC/escolha_reservas2.html');
    exit;
} else {
    // Caso falhe, mostrar erro
    echo "<h2>Credenciais inválidas.</h2>";
}
?>
