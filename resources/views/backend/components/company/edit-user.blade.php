
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header bg-info">
              <h5 class="modal-title" id="createUserModalLabel">Edit Company</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <!-- Form -->
              <form enctype="multipart/form-data" id="editUserForm">
                @csrf
                <div class="card-body row">
                    <input type="hidden" name="id" id="editUserId">
                    
                    <div class="form-group col-md-6">
                        <label for="editName">Name</label>
                        <input name="name" type="text" class="form-control" id="editName" placeholder="Enter name" required>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                         @enderror
                    </div>
            
                    <div class="form-group col-md-6">
                        <label for="editEmail">Email address</label>
                        <input name="email" type="email" class="form-control" id="editEmail" placeholder="Enter email" required>
                        <span id="email-availability-status"></span>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputMobile">Mobile Number</label>
                      <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text">+88</span>
                          </div>
                          <input name="phone" type="number" class="form-control" id="editPhone" placeholder="Enter mobile" required>
                      </div>
                      <span id="result"></span>
                      @error('phone')
                              <p class="text-danger">{{ $message }}</p>
                          @enderror
                    </div>
                
                <div class="form-group col-md-6">
                  <label>Role</label>
                  <select name="type" class="form-control select2" id="editType" style="width: 100%;" disabled required>
                      <option value="Company" {{ old('type') == 'Company' ? 'selected' : '' }}>Company</option>
                  </select>
                  @error('type')
                  <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="card-footer col-md-12 justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="submit" class="btn btn-primary float-right">Submit</button>
                </div>
                </div>
            </form>
            
          </div>
      </div>
  </div>
</div>


<script>
    $(document).ready(function() {
    // Email validation
    $('#editEmail').on('keyup', function() {
        var editEmail = $(this).val();
        var emailRegEx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (editEmail.length > 0) {
          if (!emailRegEx.test(editEmail)) {
              $('#email-availability-status').html('<span class="text-danger">Invalid email format.</span>');
              $('#submit').prop('disabled', true);
          } else {
              $.ajax({
                  url: '{{ route('check.email') }}',
                  method: 'POST',
                  data: {
                      _token: '{{ csrf_token() }}',
                      email: email
                  },
                  success: function(response) {
                    
                      if (response.exists) {
                          $('#email-availability-status').html('<span class="text-danger">Email is already taken.</span>');
                          $('#submit').prop('disabled', true);
                      } else {
                          $('#email-availability-status').html('<span class="text-success">Email is available.</span>');
                          $('#submit').prop('disabled', false);
                      }
                  }
              });
          }
      } else {
          $('#email-availability-status').html('');
      }
    });

    // Phone validation
    $('#editPhone').on('keyup', function() {
        var phone = $(this).val();

        $.ajax({
            url: '{{ route('check.phone') }}',
            type: 'POST',
            data: {
                phone: phone,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                if (response.status === 'success') {
                    $('#result').html('<span class="text-success">Phone number is valid</span>');
                    $('#submit').prop('disabled', false);
                } else {
                    $('#result').html('<span class="text-danger">Phone number is not valid</span>');
                    $('#submit').prop('disabled', true);
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
});
 $(document).on('click', '#editBtn', function() {
    var url = $(this).data('url'); 
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            if(response.status === 'success') {
                var user = response.data;
                $('#editUserId').val(user.id);
                $('#editName').val(user.name);
                $('#editEmail').val(user.email);
                $('#editPhone').val(user.phone);
                
                $('#editType').val(user.type).trigger('change');

                $('#editUserModal').modal('show');
            }
        },
        error: function(xhr) {
            console.error("An error occurred: " + xhr.status + " " + xhr.statusText);
        }
    });
});


</script>

<script>
  $(document).ready(function() {
          $('#editUserForm').on('submit', function(event) {
              event.preventDefault();

              $.ajax({
                  url: '{{ route('dashboard.edit-user') }}',
                  method: 'POST',
                  data: $(this).serialize(),
                  success: function(response) {
                      if(response.status === 'success') {
                          Swal.fire({
                              icon: 'success',
                              title: 'Success',
                              text: response.message,
                          });
                          setTimeout(function() {
                              window.location.href = '{{ route('dashboard.company-list') }}';
                          }, 2000);
                      } 
                  },
                  error: function(xhr) {
                      let errors = xhr.responseJSON.errors;
                      let errorMessage = '';
                      for (let key in errors) {
                          errorMessage += errors[key][0] + '\n';
                      }
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: errorMessage,
                      });
                  }
              });
          });
      });
</script>