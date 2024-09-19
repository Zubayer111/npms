
<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include your form here -->
                <form action="{{ route('dashboard.create-user') }}" method="POST" id="createUserForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputName">Name</label>
                            <input name="name" type="text" class="form-control" value="{{ old('name') }}" id="name" placeholder="Enter name" required>
                            @error('name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
      
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Email address</label>
                            <input name="email" type="email" class="form-control" value="{{ old('email') }}" id="email" placeholder="Enter email" required>
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
                              <input name="phone" type="number" class="form-control" value="{{ old('phone') }}" id="phone" placeholder="Enter mobile" required>
                          </div>
                          <span id="result"></span>
                          @error('phone')
                              <p class="text-danger">{{ $message }}</p>
                          @enderror
                        </div>
      
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Password</label>
                            <input name="password" type="password" class="form-control" id="password" value="{{ old('password') }}" placeholder="Password" required>
                            <span id="passwordStrength" style="color: red;"></span>
                            @error('password')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
      
                        <div class="form-group col-md-6">
                            <label>Role</label>
                            <select name="type" class="form-control select2" style="width: 100%;" required>
                                <option value="" {{ old('type') == '' ? 'selected' : '' }}>Select Role</option>
                                <option value="Admin" {{ old('type') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Doctor" {{ old('type') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                                <option value="Company" {{ old('type') == 'Company' ? 'selected' : '' }}>Company</option>
                                <option value="Patient" {{ old('type') == 'Patient' ? 'selected' : '' }}>Patient</option>
                            </select>
                            @error('type')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer col-md-12 justify-content-between">
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close" ><span class="btn btn-dark" aria-hidden="true">Cancel</span></button>
                        <button type="submit" class="btn btn-primary float-right" id="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
  $('#email').on('keyup', function() {
      var email = $(this).val();
      var emailRegEx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (email.length > 0) {
          if (!emailRegEx.test(email)) {
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
});

$(document).ready(function() {
    var debounceTimer;
    $('#phone').on('keyup', function() {
        clearTimeout(debounceTimer); 
        var phone = $(this).val();

        debounceTimer = setTimeout(function() { 
            $.ajax({
                url: '{{ route('check.phone') }}',
                type: 'POST',
                data: {
                    phone: phone,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    $('#result').html('<span class="text-info">Checking...</span>');
                    $('#submit').prop('disabled', true);
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#result').html('<span class="text-success">Phone number is valid</span>');
                        $('#submit').prop('disabled', false);
                    } else if (response.status === 'exists') {
                        $('#result').html('<span class="text-danger">Phone number is already taken</span>');
                        $('#submit').prop('disabled', true);
                    } else {
                        $('#result').html('<span class="text-danger">Phone number is not valid</span>');
                        $('#submit').prop('disabled', true);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }, 300); // Debounce time in milliseconds
    });
});

        
        $(document).ready(function() {
            $('#password').on('keyup', function() {
                var password = $(this).val();
                $.ajax({
                    url: '{{ route("dashboard.check-password-strength") }}',
                    type: 'GET',
                    data: { password: password },
                    success: function(response) {
                        var strengthText = "";
                        switch(response.strength) {
                            case 0:
                                strengthText = "Minmum 8 characters";
                                break;
                            case 1:
                                strengthText = "Very Weak";
                                break;
                            case 2:
                                strengthText = "Weak";
                                break;
                            case 3:
                                strengthText = "Medium";
                                break;
                            case 4:
                                strengthText = "Strong";
                                break;
                            case 5:
                                strengthText = "Very Strong";
                                break;
                            case 6:
                                strengthText = "Minmum 8 characters";
                                break;
                        }
                        $('#passwordStrength').text('Password Strength: ' + strengthText);
                    }
                });
            });
        });
    
</script>

<script>
    $(document).ready(function() {
            $('#createUserForm').on('submit', function(event) {
                event.preventDefault();

                $.ajax({
                    url: '{{ route('dashboard.create-user') }}',
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
                                window.location.href = '{{ route('dashboard.user-list-page') }}';
                            }, 2000);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
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
