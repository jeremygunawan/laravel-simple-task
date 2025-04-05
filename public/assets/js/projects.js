'use strict'


$(document).ready(function () {
  $('.btn-delete').on('click', function(e){
    e.preventDefault();
    let projectID = $(this).data('id');
    console.log(projectID);
    Swal.fire({
      title: 'Are you sure?',
      text: "Deleted data cannot be revert",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        deleteProject(projectID);
        
      }
    });
    
  })
});

function deleteProject(id){
	let request = $.ajax({
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
          },
          url: "/projects/delete",
          type: "post",
          data: {
            'id' : id,
        },
        success: function(res){
          $.toast({
            heading: 'Success!',
            text: `Project Deleted!`,
            icon: 'success',
            loader: false,
            hideAfter: 2000,
            position: 'top-right',
            afterHidden: function () {
              window.location = '/projects';
            }
          });
        },
        error: function(res){
          
        },
        complete: function() {
          
        }
    });
}
