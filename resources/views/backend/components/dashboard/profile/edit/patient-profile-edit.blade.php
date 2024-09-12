<div class="content-wrapper">
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Patient Profile Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Patient Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">Update Patient Profile</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{route('dashboard.patient.profile.update')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card-body row">
              <div class="form-group col-md-6">
                  <div class="form-group">
                      <label for="exampleInputFile">File input</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input name="profile_photo" type="file" class="custom-file-input" id="exampleInputFile" value="{{$user->profile_photo ?? ''}}" required>
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div>
                      </div>
                      
                    </div>
              </div>
              <div class="text-center">
                @if ($user && $user->profile_photo)
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset($user->profile_photo) }}" alt="User profile picture">
                @else
                    
                @endif
              </div>
              <div class="form-group col-md-6">
                  <label for="exampleInputName">First Name</label>
                  <input name="first_name" type="text" class="form-control" id="exampleInputName" placeholder="Enter first name" value="{{$user->first_name ?? ''}}" required>
              </div>
                  
              
              <div class="form-group col-md-6">
                <label for="exampleInputName">Meddil Name</label>
                <input name="middle_name" type="text" class="form-control" id="exampleInputName" placeholder="Enter first name" value="{{$user->middle_name ?? ''}}" required>
            </div>
              <div class="form-group col-md-6">
                <label for="exampleInputMobile">Last Name</label>
                <input name="last_name" type="text" class="form-control" id="exampleInputMobile" placeholder="Enter last name" value="{{$user->last_name ?? ''}}" required>
              </div>
              <div class="form-group col-md-6">
                  <label for="exampleInputMobile">Email</label>
                  <input name="email" type="email" class="form-control" id="email" placeholder="Enter email" value="{{$user->email ?? ''}}" required>
                  <span id="email-availability-status"></span>
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputMobile">Mobile Number</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">+88</span>
                    </div>
                    <input name="phone_number" type="number" class="form-control" value="{{ $user->phone_number ?? '' }}" id="phone" placeholder="Enter mobile"  required>
                </div>
                <span id="result"></span>
                @error('phone')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label>Gender</label>
                <select name="gender" class="form-control select2" style="width: 100%;" required>
                  <option value="" selected="selected">Select Gender</option>
                  <option value="Male" {{ $user && $user->gender == 'Male' ? 'selected' : '' }}>Mail</option>
                  <option value="Female" {{ $user && $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                  <option value="Other" {{ $user && $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="form-group col-md-3">
              <label>Marital Status</label>
              <select name="marital_status" class="form-control select2" style="width: 100%;" required>
                <option value="" selected="selected">Select Marital Status</option>
                <option value="Married" {{ $user && $user->marital_status == 'Married' ? 'selected' : '' }}>Married</option>
                <option value="Unmarried" {{ $user && $user->marital_status == 'Unmarried' ? 'selected' : '' }}>Unmarried</option>
                <option value="Separated" {{ $user && $user->marital_status == 'Separated' ? 'selected' : '' }}>Separated</option>
                <option value="Widowed" {{ $user && $user->marital_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                <option value="Single" {{ $user && $user->marital_status == 'Single' ? 'selected' : '' }}>Single</option>
                <option value="Life Partner" {{ $user && $user->marital_status == 'Life Partner' ? 'selected' : '' }}>Life Partner</option>
              </select>
            </div>
            <div class="form-group col-md-3">
                <label>Blood Group</label>
                <select name="blood_group" class="form-control select2" style="width: 100%;" required>
                  <option value="" selected="selected">Select Blood Group</option>
                  <option value="A+" {{ $user && $user->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                  <option value="A-" {{ $user && $user->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                  <option value="B+" {{ $user && $user->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                  <option value="B-" {{ $user && $user->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                  <option value="O+" {{ $user && $user->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                  <option value="O-" {{ $user && $user->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
                  <option value="AB+" {{ $user && $user->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                  <option value="AB-" {{ $user && $user->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
                </select>
            </div>
                  <div class="form-group col-md-3">
                      <label>Smoking Status</label>
                      <select name="smoking_status" class="form-control select2" style="width: 100%;" required>
                        <option value="" selected="selected">Select Smoking Status</option>
                        <option value="smoker" {{ $user && $user->smoking_status == 'smoker' ? 'selected' : '' }}>Smoker</option>
                        <option value="non smoker" {{ $user && $user->smoking_status == 'non smoker' ? 'selected' : '' }}>Non Smoker</option>
                      </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Alcohole Status</label>
                    <select name="alcohole_status" class="form-control select2" style="width: 100%;" required>
                      <option value="" selected="selected">Select Alcohole Status</option>
                      <option value="alcoholic" {{ $user && $user->alcohole_status == 'alcoholic' ? 'selected' : '' }}>Alcoholic</option>
                      <option value="non alcoholic" {{ $user && $user->alcohole_status == 'non alcoholic' ? 'selected' : '' }}>Non Alcoholic</option>
                    </select>
                </div>
                  <div class="form-group col-md-3">
                    <label>Economical Status</label>
                    <select name="economical_status" class="form-control select2" style="width: 100%;" required>
                      <option value="" selected="selected">Select Economical Status</option>
                      <option value="rich" {{ $user && $user->economical_status == 'rich' ? 'selected' : '' }}>Rich</option>
                      <option value="middle class" {{ $user && $user->economical_status == 'middle class' ? 'selected' : '' }}>Middle Class</option>
                      <option value="poor" {{ $user && $user->economical_status == 'poor' ? 'selected' : '' }}>Poor</option>
                    </select>
                </div>
                
              <div class="form-group col-md-3">
                <label for="exampleInputMobile">Date of Birth</label>
                <input name="dob" type="date" class="form-control"  value="{{ isset($user) ? $user->dob->format('Y-m-d') : '' }}" required>
              </div>
              <div class="form-group col-md-3">
                <label for="exampleInputMobile">Reference Time</label>
                <input name="reference_time" type="date" class="form-control"  value="{{ isset($user) ? $user->reference_time->format('Y-m-d') : '' }}"  required>
              </div>
              
              <div class="form-group col-md-3">
                <label for="exampleInputMobile">Height</label>
                <input name="height" type="number" step="0.01" class="form-control" id="exampleInputMobile" placeholder="Enter height" value="{{$user->height ?? ''}}" required>
              </div>
              <div class="form-group col-md-3">
                <label for="exampleInputMobile">Weight</label>
                <input name="weight" type="number" step="0.01" class="form-control" id="exampleInputMobile" placeholder="Enter last name" value="{{$user->weight ?? ''}}" required>
              </div>
              <div class="form-group col-md-3">
                <label for="exampleInputMobile">BMI</label>
                <input name="bmi" type="number" step="0.01" class="form-control" id="exampleInputMobile" placeholder="Enter bmi" value="{{$user->bmi ?? ''}}" required>
              </div>
              <div class="form-group col-md-6">
                  <label for="exampleInputName">Present Address</label>
                  <input name="address_one" type="text" class="form-control" id="exampleInputName" placeholder="Enter present address" value="{{$user->address_one ?? ''}}" required>
              </div>
                  
              
              <div class="form-group col-md-6">
                  <label for="exampleInputEmail1">Permanent Address</label>
                  <input name="address_two" type="text"  class="form-control" id="exampleInputName" placeholder="Enter permanent address" value="{{$user->address_two ?? ''}}" required>
                  
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputMobile">City</label>
                <input name="city" type="text" class="form-control" id="exampleInputMobile" placeholder="Enter city" value="{{$user->city ?? ''}}" required>
              </div>
              <div class="form-group col-md-6">
                  <label for="exampleInputMobile">State</label>
                  <input name="state" type="text" class="form-control" id="exampleInputMobile" placeholder="Enter state" value="{{$user->state ?? ''}}" required>
              </div>
              <div class="form-group col-md-6">
                  <label for="exampleInputMobile">Zip Code</label>
                  <input name="zipCode" type="text" class="form-control" id="exampleInputMobile" placeholder="Enter zip code" value="{{$user->zipCode ?? ''}}" required>
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputMobile">History</label>
                <textarea name="history" class="form-control"   placeholder="Enter history" required>{{$user->history ?? ''}}</textarea>
            </div>
            <div class="form-group col-md-6">
              <label for="exampleInputMobile">Employer Details</label>
              <textarea name="employer_details" class="form-control"   placeholder="Enter history" required>{{$user->employer_details ?? ''}}</textarea>
            </div>
            <div class="form-group col-md-6">
              <label for="exampleInputMobile">Reference Note</label>
              <textarea name="reference_note" class="form-control"  placeholder="Enter reference note" required>{{$user->reference_note ?? ''}}</textarea>
            </div>
          </div>
          
        <!-- /.card-body -->
        
        
        <div class="card-footer col-md-12 justify-content-between">
          <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ url('dashboard/profile') }}'">Cancel</button>
          <button type="submit" class="btn btn-primary float-right" id="submit">Submit</button>
      </div>
      </form>
      
    </div>
    </section>
</div> 
<script>
// $(function () {
//   bsCustomFileInput.init();
// });
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
            $('#phone').on('keyup', function() {
                var phone = $(this).val();

                $.ajax({
                    url: '{{ route('check.phone') }}',
                    type: 'POST',
                    data: {
                        phone: phone,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
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
</script>   