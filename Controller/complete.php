<?php

if (isset($_POST['id'])) {
    require './db_conn.php';

    $id = $_POST['id'];

    $stmt = $conn->prepare("UPDATE todos SET checked = 1 WHERE id = ?");
    $res = $stmt->execute([$id]);

    if ($res) {
        echo 'success';
    } else {
        echo 'error';
    }
    $conn = null;
    exit();
}
