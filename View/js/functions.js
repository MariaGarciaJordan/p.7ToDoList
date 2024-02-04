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