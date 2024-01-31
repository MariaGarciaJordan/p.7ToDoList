<?php
require 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>To Do List</title>
</head>
<body>
    <div class="main-section">
        <div class="add-section">
            <form action="">
                <input type="text" 
                        name="title" 
                        placeholder="This field required"/>
                <button type="submit">Add &nbsp; <span>&#43;</span></button>
            </form>
        </div>
        <div class="show-todo-section">
        <?php
        ?>
        <div class="todo-item">
            <input type="checkbox">
            <h2>This is</h2>
            <br>
            <small>created: 30/01/24</small>
        </div>    
           
        </div>
    </div>
</body>
</html>