<?php
include 'database.php';

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $date = date('Y-m-d H:i:s',time());

    $db = new Database();
    $res = $db->update('messages', [
        'username' => $name,
        'email' => $email,
        'phone' => $phone,
        'subject' => $subject,
        'message' => $message,
        'updated' => $date
        ],
        [
            'id' => $id
        ]
    );
    if ($res !== false) {
        header('location:index.php');
    } else {
        die('Произошла ошибка обновления данных');
    }
}
?>>