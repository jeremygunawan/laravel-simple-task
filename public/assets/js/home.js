'use strict'

$(document).ready(function () {
  initTableTask();
  
  $('#project-dropdown').on('change', function (e) {
    e.preventDefault();
    let projectID = $(this).val();
    
    let loadingSpinner = `<div class="d-flex justify-content-center">
  <div class="spinner-border" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>`;

    $('#task-table tbody').css('display', 'table-caption')
    $('#task-table tbody').html(loadingSpinner);

    var rowTable = '';

    $.ajax({
      beforeSend: function (xhr) {
        xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
      },
      url: BASE_URL + '/tasks/load-project/' + projectID,
      type: 'get',
      complete: function () {
        $('#task-table tbody').css('display', 'revert')
        $('#task-table tbody').html(rowTable);
        initTableTask();
      },
      success: function (res) {
        
        let tasks = res.data.tasks;

        for (let i = 0; i < tasks.length; i++) {
            const single = tasks[i];
            let id = i + 1;
            rowTable += `<tr id="${id}" data-taskid="${single.id}">
            <td class="text-center">
                ${ single.name }
            </td>
            <td class="text-center">
                ${ single.project_name }
            </td>
            <td>
                ${ single.created_date }
            </td>
        </tr>`;
        }
        
        
      },
      error: function (err) {
        
      }
    });
  })
});

function initTableTask(){
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
}