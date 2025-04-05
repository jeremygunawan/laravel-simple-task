'use strict'

$(document).ready(function () {
  $('#task-table').tableDnD({
    onDragClass: "drag-row",
    onDrop: function(table, row) {
        var rows = $('#task-table tbody tr');
        var debugStr = "Row dropped was "+row.id+".";
        let newOrder = [];
        
        for (var i=0; i<rows.length; i++) {
          // debugStr += $(rows[i]).attr('id')+" ";
          let taskID = $(rows[i]).data('taskid');
          newOrder.push(taskID)
        }

        $(table).parent().find('.result').text(debugStr);

        $.ajax({
          beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
          },
          url: BASE_URL + '/tasks/order-priority',
          type: 'post',
          data: {
            'ordering': newOrder
          },
          complete: function () {
            
          },
          success: function (res) {
            
          },
          error: function (err) {
            
          }
        });
    },
		onDragStart: function(table, row) {
			$(table).parent().find('.result').text("Started dragging row "+row.id);
		}
  });
  $('#btn-add-task').on('click', function (e) {
    e.preventDefault();

    $('#form-addtask').trigger("reset");
    $('#form-addtask').attr('action', "/tasks/create");
    $('#btn-submit-task').val('Add');

    $('#add-task-modal').modal('show');
  })

  $('.btn-info').on('click', function (e) {
    e.preventDefault();
    let taskID = $(this).data('id');

    $.ajax({
      beforeSend: function (xhr) {
        xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
      },
      url: BASE_URL + '/tasks/load/' + taskID,
      type: 'get',
      complete: function () {
        $('#add-task-modal').modal('show');
      },
      success: function (res) {
        let name = res.data.task.name;
        let project = res.data.task.project_id;

        $('#form-addtask').attr('action', "/tasks/edit/"+taskID);
        $('input[name="name"]').val(name);
        $('#project-dropdown').val(project);
        $('#btn-submit-task').val('Update');
        
      },
      error: function (err) {
        
      }
    });
  })

  $('.btn-delete').on('click', function (e) {
    e.preventDefault();
    let taskID = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: "Deleted data cannot be revert",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        deleteTask(taskID);
      }
    });

  })
});

$('#form-addtask').on("submit", function (e) {
  e.preventDefault();
  var $this = $(this);

  var alertEl = $this.find('.alert');
  alertEl.css('display', 'none');
  $this.find('input').removeClass('is-invalid');

  buttonLoading('#btn-submit-task');
  $.ajax({
    beforeSend: function (xhr) {
      xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
    },
    url: BASE_URL + $this.attr('action'),
    data: $this.serialize(),
    type: $this.attr('method'),
    complete: function () {

    },
    success: function (res) {
      $.toast({
        heading: 'Success!',
        text: res.message,
        icon: 'success',
        loader: false,
        hideAfter: 2000,
        position: 'top-right',
        afterHidden: function () {
          window.location = BASE_URL + '/tasks';
        }
      });
    },
    error: function (err) {
      if (err.status == 422) { // when status code is 422, it's a validation issue
        // display errors on each form field
        $.each(err.responseJSON.errors, function (i, error) {
          alertEl.find('.error-list').html('<li><strong>' + error[0] + '</strong></li>');
          alertEl.css('display', 'block');
          $this.find('input[name="' + i + '"]').addClass('is-invalid');
        });
        buttonUnloading('#btn-submit-task');
      }
    }
  });
});

function deleteTask(id){
	let request = $.ajax({
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
          },
          url: "/tasks/delete",
          type: "post",
          data: {
            'id' : id,
        },
        success: function(res){
          $.toast({
            heading: 'Success!',
            text: `Task Deleted!`,
            icon: 'success',
            loader: false,
            hideAfter: 2000,
            position: 'top-right',
            afterHidden: function () {
              window.location = '/tasks';
            }
          });
        },
        error: function(res){
          
        },
        complete: function() {
          
        }
    });
}