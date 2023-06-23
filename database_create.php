<?php
$dbName = 'test_crud_app';
// Create connection
$conn = new mysqli('localhost', 'root', '');
// Check connection
if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) === TRUE) {
    echo "База данных test_crud_app создана успешно.".PHP_EOL;
    $conn->select_db($dbName);
    $tableSql = "CREATE TABLE IF NOT EXISTS messages (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL,
    phone VARCHAR(12),
    subject VARCHAR(50),
    message VARCHAR(150),
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    if ($conn->query($tableSql) === TRUE) {
        echo "Таблица messages создана успешно.".PHP_EOL;
        $conn->close();
        header('location:index.php');
    } else {
        echo "Ошибка создания таблицы: " . $conn->error;
    }

} else {
    echo "Ошибка создания базы данных: " . $conn->error;
}
$conn->close();


