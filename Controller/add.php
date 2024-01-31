<?php

if(isset($_POST['title'])){
    require '../db_conn.php';

    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];

    if(empty($title)){
        header("Location: ../index.php?mess=error");
    }else {
        $stmt = $conn->prepare("INSERT INTO todos(title, description, priority) VALUE(?, ?, ?)");
        $res = $stmt->execute([$title, $description, $priority]);

        if($res){
            header("Location: ../index.php?mess=success"); 
        }else {
            header("Location: ../index.php");
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}