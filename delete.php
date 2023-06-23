<?php
include 'database.php';

$id = $_GET['id'];

$db = new Database();
$res = $db->delete('messages', ['id' => $id]);
if ($res !== false) {
    header('location:index.php');
} else {
    die('Произошла ошибка удаления данных');
}
?>