<?php
// Iniciar sessão, se quiseres guardar estado de login
session_start();

// Abrir a base de dados
$db = new SQLite3('../database/hotel.db'); // ajusta o caminho conforme necessário

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepara consulta
    $stmt = $db->prepare("SELECT password FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $result = $stmt->execute();

    // Verifica se encontrou utilizador
    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        // Verifica a password (com hash)
        if (password_verify($password, $row['password'])) {
            echo "<h2>Login efetuado com sucesso!</h2>";
            // Exemplo: guardar sessão do utilizador
            $_SESSION['email'] = $email;
        } else {
            echo "<h2>Palavra-passe incorreta.</h2>";
        }
    } else {
        echo "<h2>Utilizador não encontrado.</h2>";
    }
} else {
    echo "Acesso inválido ao ficheiro.";
}
?>
