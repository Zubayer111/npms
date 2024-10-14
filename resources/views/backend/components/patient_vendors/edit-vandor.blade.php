
<div class="modal fade" id="editPatientVandorModal" tabindex="-1" role="dialog" aria-labelledby="editPatientVandorModalModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header bg-info">
              <h5 class="modal-title" id="editPatientVandorModalModalLabel">Edit Patien Vendor</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <!-- Form -->
              <form id="editPatientVandorForm" enctype="multipart/form-data">
                @csrf
                <div class="card-body row">
                    <div class="form-group col-md-6">
                        <input type="hidden" name="id" id="id">
                        <label for="exampleInputName">Name</label>
                        <input name="name" type="text" class="form-control" value="{{ old('name') }}" id="edit_name" placeholder="Enter name" required>
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Email address</label>
                        <input name="email" type="email" class="form-control" value="{{ old('email') }}" id="edit_email" placeholder="Enter email" required>
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
                          <input name="phone" type="number" class="form-control" value="{{ old('phone') }}" id="edit_phone" placeholder="Enter mobile" required>
                      </div>
                      <span id="result"></span>
                      @error('phone')
                          <p class="text-danger">{{ $message }}</p>
                      @enderror
                  </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputPassword1">FAX</label>
                        <input name="fax" type="number" class="form-control" id="edit_fax" value="{{ old('fax') }}" placeholder="Enter fax" >
                        @error('fax')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputPassword1">Address</label>
                        <input name="address" type="text" class="form-control" id="edit_address" value="{{ old('address') }}" placeholder="Enter address" required>
                        @error('address')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputPassword1">Contact Person</label>
                        <input name="contact_person" type="text" class="form-control" id="edit_contact_person" value="{{ old('contact_person') }}" placeholder="Enter contact person" required>
                        @error('contact_person')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="Status">Status</label>
                        <select name="status" id="edit_status" class="form-control" required>
                            <option value="" selected="selected">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>                            
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
 $(document).on('click', '#editBtn', function() {
    var url = $(this).data('url'); 
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            if(response.status === 'success') {
                var vandor = response.data;
                $('#id').val(vandor.id);
                $('#edit_name').val(vandor.name);
                $('#edit_email').val(vandor.email);
                $('#edit_phone').val(vandor.phone);
                $('#edit_fax').val(vandor.fax);
                $('#edit_address').val(vandor.address);
                $('#edit_contact_person').val(vandor.contact_person);
                
                $('#edit_status').val(vandor.status).trigger('change');

                $('#editPatientVandorModal').modal('show');
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
          $('#editPatientVandorForm').on('submit', function(event) {
              event.preventDefault();

              $.ajax({
                  url: '{{ route('dashboard.update-patient-vandor') }}',
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