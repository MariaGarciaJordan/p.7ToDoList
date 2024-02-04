<?php

require '../Model/Task.php';

if (isset($_POST['title'])) {
    
    require '../db_conn.php';

    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];

    if (empty($title)) {
        header("Location: ../index.php?mess=error");
    } else {
        
        $task = new Task($title,$description,$priority);

        $stmt = $conn->prepare("INSERT INTO todos(title, description, priority) VALUE(?, ?, ?)");
        $res = $stmt->execute([
            $task->getTitle(),
            $task->getDescription(),
            $task->getPriority()
        ]);

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