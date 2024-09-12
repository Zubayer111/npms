<div class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
          <div class="card-header text-center">
            <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
          </div>
          <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>
      
            <form action="{{route("user-login")}}" method="post">
              @csrf
              <div class="form-group col-md-12">
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
                
                
              
              <div class="row">
                <div class="col-8">
                  
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button id="submit" type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
      
            {{-- <div class="social-auth-links text-center mt-2 mb-3">
              <a href="#" class="btn btn-block btn-primary">
                <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
              </a>
              <a href="#" class="btn btn-block btn-danger">
                <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
              </a>
            </div> --}}
            <!-- /.social-auth-links -->
      
            
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
{{-- 
<script>
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
                  alert(response.status);
                    if (response.status === 'success') {
                      alert('Phone number is valid');
                        $('#result').html('<span class="text-success">Phone number is valid</span>');
                        $('#submit').prop('disabled', false);
                    } else if (response.status === 'exists') {
                        alert('Phone number already exists');
                        $('#result').html('<span class="text-danger">Phone number is already taken</span>');
                        $('#submit').prop('disabled', true);
                    } else {
                        alert('Phone number is not valid');
                        $('#result').html('<span class="text-danger">Phone number is not valid</span>');
                        $('#submit').prop('disabled', true);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }, 300);
    });
});
</script> --}}