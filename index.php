<?php 
require 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List</title>
    <link rel="stylesheet" href="View/css/style.css">
</head>
<body>
    <div class="main-section">
        <div class="add-section">
            <form action="Controller/add.php" method="POST" autocomplete="off">
                <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error') { ?>
                    <input type="text" 
                        name="title" 
                        style="border-color: #ff6666"
                        placeholder="This field is required" />
                    <input type="text" 
                        name="description" 
                        placeholder="Describe your task" />
                    <select name="priority">
                        <option value="High">High</option>
                        <option value="Low">Low</option>
                    </select>
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>
                    
                <?php } else { ?>
                    <input type="text" 
                        name="title" 
                        placeholder="What do you need to do?" />
                    <input type="text" 
                        name="description"
                        placeholder="Describe your task" />
                    <select name="priority">
                        <option value="1">High</option>
                        <option value="0">Low</option>
                    </select>
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>
                <?php } ?>
            </form>
        </div>
        <?php 
            $order = isset($_GET['order']) ? $_GET['order'] : 'id';
            
            if ($order === 'priority') {
                $todos = $conn->query("SELECT * FROM todos ORDER BY priority DESC");
            } elseif ($order === 'date') {
                $todos = $conn->query("SELECT * FROM todos ORDER BY date_time ASC, title ASC");
            } elseif ($order === 'completed') {
                $todos = $conn->query("SELECT * FROM todos WHERE checked = 1 ORDER BY checked ASC");
            } elseif ($order === 'incomplete') {
                $todos = $conn->query("SELECT * FROM todos WHERE checked = 0");
            } else {
                $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
            }  
        ?>
       <div class="show-todo-section">
       <form action="index.php" method="GET">
           <button type="submit" name="order" value="priority">Order by Priority</button>
           <button type="submit" name="order" value="date">Order by Date</button>
           <button type="submit" name="order" value="completed">Show Completed</button>
            <button type="submit" name="order" value="incomplete">Show Incomplete</button>

       </form>

            <?php if ($todos->rowCount() <= 0) { ?>
                <div class="todo-item">
                    <div class="empty">
                        <img src="./view/images/img.png" width="100%" />
                        <img src="./View/images/cir.gif" width="80px">
                    </div>
                </div>
            <?php } ?>

            <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item" <?php 
                                            if ($todo['checked'] == 1) {
                                                echo 'style="background-color: rgb(198, 239, 199);"';
                                            }
                                        ?>>
                    <span id="<?php echo $todo['id']; ?>"
                          class="remove-to-do">x</span>
                    <span id="<?php echo $todo['id']; ?>"  
                        class="update-to-do">✔</span>
                    
                    <input type="checkbox" <?php 
                                                if ($todo['checked'] == 1) {
                                                    echo 'style="display: none;"';
                                                }
                                            ?>
                            data-todo-id ="<?php echo $todo['id']; ?>"
                            class="check-box" />
                    <h2><?php echo $todo['title'] ?></h2>
                    
                    <p><?php echo $todo['description'] ?></p>
                    <br>
                    <small>created: <?php echo $todo['date_time'] ?></small> 
                    <small>priority: <?php 
                                        if ($todo['priority'] === 1) {
                                            echo 'High'; 
                                        } else {
                                            echo 'Low';
                                        }
                                    ?>
                    </small>
                    <br>
                    <button class="complete-to-do" id="<?php echo $todo['id']; ?>">Done!</button>
                </div>
            <?php } ?>
       </div>
    </div>

    <script src="View/js/jquery-3.2.1.min.js"></script>
    <script src="View/js/functions.js"></script>

</body>
</html>