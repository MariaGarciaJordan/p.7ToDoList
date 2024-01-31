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
          } else {
              $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
          }
          
       ?>
       <div class="show-todo-section">
       <form action="index.php" method="GET">
           <button type="submit" name="order" value="priority">Order by Priority</button>
           <button type="submit" name="order" value="date">Order by Date</button>
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

    <script src="js/jquery-3.2.1.min.js"></script>

    <script>
        $(document).ready(function(){
            var originalTitle = '';
            var originalDescription = '';
            var currentCheckBox = null;

            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');
                
                $.post("Controller/remove.php", 
                      {
                          id: id
                      },
                      (data)  => {
                         if(data){
                             $(this).parent().hide(600);
                         }
                      }
                );
            });

            $(".check-box").click(function(e){
                const id = $(this).attr('data-todo-id');
                const h2 = $(this).next();
                const p = h2.next();
                const updateToDo = $(this).siblings('.update-to-do');

                if (currentCheckBox) {
                    currentCheckBox.next().text(originalTitle);
                    currentCheckBox.next().next().text(originalDescription);
                    currentCheckBox.prop('checked', false);
                    currentCheckBox.siblings('.update-to-do').hide();
                }

                if ($(this).is(':checked')) {
                    originalTitle = h2.text();
                    originalDescription = p.text();

                    h2.html('<input type="text" id="titleInput" value="' + originalTitle + '">');
                    p.html('<input type="text" id="descriptionInput" value="' + originalDescription + '">');

                    updateToDo.show();

                    currentCheckBox = $(this);
                } else {
                    h2.text(originalTitle);
                    p.text(originalDescription);

                    currentCheckBox = null;
                }
            });

            $(".update-to-do").click(function(e){
                const id = $(this).attr('id');
                const title = $('#titleInput').val();
                const description = $('#descriptionInput').val();

                $.post('Controller/update.php', 
                    {
                        id: id,
                        title: title,
                        description: description
                    },
                    (data) => {
                        if(data != 'error'){
                            location.reload(); 
                        }
                    }
                );
                $('.check-box').not(this).prop('checked', false);
            });

            $(".complete-to-do").click(function(e){
                const id = $(this).attr('id');

                $.post('Controller/complete.php', 
                    {
                        id: id
                    },
                    (data) => {
                        if(data != 'error'){
                            $(this).parent().css('background-color', '#c6efc7');
                            $(this).siblings('.check-box').hide();
                        }
                    }
                );
            });

        });
    </script>
</body>
</html>