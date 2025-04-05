$('#form-adddepartment').on("submit", function(e){
    $this = $(this);
    e.preventDefault();

    var el = $(document).find('#add-department-error');
    el.css('display', 'none');
    $this.find('input').removeClass('is-invalid');

    buttonLoading('#btn-add-department');
    $.ajax({
        beforeSend: function(xhr){
              xhr.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
        },
        url: BASE_URL+$this.attr('action'),
        data: $this.serialize(),
        type: $this.attr('method'),
        complete: function() {

        },
        success: function(res){
          $.toast({
              heading: 'Success!',
              text: `Success Add New Department.`,
              icon: 'success',
              loader: false,
              hideAfter: 2000,
              position: 'top-right',
              afterHidden: function () {
                $('#form-adddepartment').trigger("reset");
                window.location = BASE_URL+'department';
              }
          });
        },
        error: function (err) {
            if (err.status == 422) { // when status code is 422, it's a validation issue
                // display errors on each form field
                $.each(err.responseJSON.errors, function (i, error) {
                    el.find('.error-list').html('<li><strong>'+error[0]+'</strong></li>');
                    el.css('display', 'block');
                    $this.find('input[name="'+i+'"]').addClass('is-invalid');
                });
                buttonUnloading('#btn-add-department');
            }
        }
      });
  });