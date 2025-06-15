<?php

// registo.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Criar ligação à base de dados
$db = new SQLite3('/home/sergio/public_html/Site_reservas_DEAPC/database/hotel.db', SQLITE3_OPEN_READWRITE);


//Recebe os dados do formulário
$Nome = $_POST['Nome'] ?? '';
$Telefone = $_POST['Telefone'] ?? '';
$Data_nascimento = $_POST['Data_nascimento'] ?? '';
$Email = $_POST['Email'] ?? '';
$Password = $_POST['Password'] ?? '';

// Inserir dados
$stmt = $db->prepare("INSERT INTO users (Nome, Telefone, Data_nascimento, Email, Password)
                      VALUES (:Nome, :Telefone, :Data_nascimento, :Email, :Password)");
$stmt->bindValue(':Nome', $Nome, SQLITE3_TEXT);
$stmt->bindValue(':Telefone', $Telefone, SQLITE3_TEXT);
$stmt->bindValue(':Data_nascimento', $Data_nascimento, SQLITE3_TEXT);
$stmt->bindValue(':Email', $Email, SQLITE3_TEXT);
$stmt->bindValue(':Password', password_hash($Password, PASSWORD_DEFAULT), SQLITE3_TEXT);

$result = $stmt->execute();

if ($result) {
    echo "<h2>Registo efetuado com sucesso!</h2>";
} else {
    echo "<h2>Erro ao registar: " . $db->lastErrorMsg() . "</h2>";
}
?>