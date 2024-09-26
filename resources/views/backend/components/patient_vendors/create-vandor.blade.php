<!-- Create admin Modal -->
<div class="modal fade" id="createPatienVendor" tabindex="-1" role="dialog" aria-labelledby="createPatienVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="createPatienVendorModalLabel">Create Patien Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include your form here -->
                <form id="createPatienVendorForm" enctype="multipart/form-data">
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
                            <label for="exampleInputPassword1">FAX</label>
                            <input name="fax" type="number" class="form-control" id="fax" value="{{ old('fax') }}" placeholder="Enter fax" >
                            @error('fax')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Address</label>
                            <input name="address" type="text" class="form-control" id="address" value="{{ old('address') }}" placeholder="Enter address" required>
                            @error('address')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Contact Person</label>
                            <input name="contact_person" type="text" class="form-control" id="contact_person" value="{{ old('contact_person') }}" placeholder="Enter contact person" required>
                            @error('contact_person')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer col-md-12 justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success float-right" id="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#createPatienVendorForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('dashboard.create-patient-vandor') }}',
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
                            window.location.href = '{{ route('dashboard.patient-vandor-list') }}';
                        }, 2000);
                    } 
                    else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                        });
                    }
                },
                error: function(xhr) {
                    // Handle validation or server errors
                    let errorMessage = '';

                    if (xhr.status === 422) { // Laravel validation errors
                        const errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).map(function(error) {
                            return error.join(' '); // Combine all error messages into a single string
                        }).join('<br>');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message; // Custom exception message from Laravel
                    } else {
                        errorMessage = 'An unexpected error occurred. Please try again later.';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorMessage, // Use 'html' instead of 'text' to display line breaks
                    });
                }
            });
        });
    });
</script>



  