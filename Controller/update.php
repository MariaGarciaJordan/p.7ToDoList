<?php

if(isset($_POST['id'], $_POST['title'], $_POST['description'])) {
    require '../db_conn.php';

    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (empty($title)) {
        header("Location: ../index.php?mess=error");
    } else {
        $stmt = $conn->prepare("UPDATE todos SET title = ?, description = ? WHERE id = ?");
        $res = $stmt->execute([$title, $description, $id]);

        if ($res) {
            header("Location: ../index.php?mess=success"); 
        } else {
            header("Location: ../index.php");
        }
        $conn = null;
        exit();
    }
} else {
    header("Location: ../index.php?mess=error");
}