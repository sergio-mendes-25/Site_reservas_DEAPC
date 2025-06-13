<?php
 $db = new SQLite3('reservas.db');

 CREATE TABLE reservas (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nome_utilizador TEXT NOT NULL,
  data_reserva TEXT,
  tipo TEXT,
  subtipo TEXT,
  checkin TEXT,
  checkout TEXT,
  pagamento INTEGER
);

?> 