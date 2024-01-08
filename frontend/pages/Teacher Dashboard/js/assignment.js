function showAddModal() {
    $('#addModal').fadeIn();
  }
  // Hide the add form when the "Cancel" button is clicked
  $('#closeForm').on('click', function () {
      $('#addModal').fadeOut();
  });
  
  $(document).ready(function () {
    // Show the add form when the "Add" button is clicked
    $('#showForm').on('click', function (e) {
        e.preventDefault();  // Prevent the default form submission
        e.stopPropagation(); // Stop event propagation
        showAddModal();
    });
  
    // insertion function (Add button)
    $("#adddata").on("click", function (e) {
        e.preventDefault();  // Prevent the default form submission
  
        var formData = $("#addForm").serialize();
  
        $.ajax({
            url: "php/function.php",
            type: "POST",
            data: formData,
            success: function (response) {
                // Append the new row to the existing table
                $('#table1 tbody').append(response);
  
                // Clear the input fields
                $("#addForm")[0].reset();
  
                // Hide the add form after successful addition
                $('#addModal').fadeOut();
            },
            complete: function () {
                // Scroll to the bottom of the table to show the newly added row
                $('#table1').animate({
                    scrollTop: $('#table1 tbody').height()
                }, 1000);
            }
        });
    });
  
    // update
    $(document).on('click', '#table1 .edit', function () {
        $('#table1').find('.save, .cancel').hide();
        $('#table1').find('.edit').show();
        $(this).hide().siblings('.save, .cancel').show();
  
        $(this).closest('tr').find('td[data-id]').each(function () {
            if (!$(this).is(':last-child')) { // Exclude the last child (buttons)
                var inp = $(this).find('input');
                if (inp.length) {
                    $(this).text(inp.val());
                } else {
                    $(this).attr('contenteditable', 'true');
                }
            }
        });
    });
  
    // cancel
    $(document).on('click', '#table1 .cancel', function () {
        $('#table1').find('.save, .cancel').hide();
        $(this).hide().siblings('.edit').show();
        $(this).closest('tr').find('td[data-id]').each(function () {
            $(this).attr('contenteditable', 'false');
        });
    });
  
    // insertion function (SAVE button)
    $(document).on('click', '#table1 .save', function () {
        var $btn = $(this);
        $('#table1').find('.save, .cancel').hide();
        $btn.hide().siblings('.edit').show();
        params = "";
  
        var id = $btn.data('id');
  
        $btn.closest('tr').find('td[data-id]').each(function () {
            $(this).attr('contenteditable', 'false');
            if (params != "") {
                params += "&";
            }
            params += $(this).data('id') + "=" + $(this).text();
        });
  
        params += "&id=" + id;
  
        if (params != "") {
            $.ajax({
                url: "php/function.php",
                type: "POST",
                data: params,
                success: function (response) {
                    $("#ajax-response").html(response);
                }
            });
        }
    });
  
    // delete
    $(document).on('click', '#table1 .del', function () {
        var ele = this;
        var deleteid = $(this).data('id');
  
        var confirmalert = confirm('Are you sure you want to delete it ?');
  
        if (confirmalert == true) {
            $.ajax({
                url: "php/function.php",
                type: "POST",
                data: {
                    id: deleteid,
                    action: 'del'
                },
                success: function (response) {
                    if (response == 1) {
                        $(ele).closest('tr').css('background', 'tomato');
                        $(ele).closest('tr').fadeOut(800, function () {
                            $(this).remove();
                        });
                    } else {
                        alert('Deleting row Failed');
                    }
                }
            });
        }
    });
  
    // Hide the add form when the "Close" button is clicked
    $('#addModal .close').on('click', function () {
        $('#addModal').fadeOut();
    });
  
    // Hide the add form when clicking outside the form
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#addModal').length && !$(e.target).is('#showForm')) {
            $('#addModal').fadeOut();
        }
    });
  });
  