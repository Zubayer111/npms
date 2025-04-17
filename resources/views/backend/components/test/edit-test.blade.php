<div class="modal fade" id="editMedicalTest" tabindex="-1" role="dialog" aria-labelledby="editMedicalTestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="editMedicalTest">Edit Test</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include your form here -->
                <form id="editMedicalTestForm"  method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body row">
                        <input type="hidden" name="test_id" id="id" value="">
                        <div class="form-group col-md-12">
                            <label for="exampleInputName">Test Name</label>
                            <input name="test_name" type="text" id="edit_test_name" class="form-control" value="{{ old('test_name') }}" id="name" placeholder="Enter test name" required>
                            <span id="diseaseNameError" style="color: red;"></span>
                            @error('test_name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="Status">Status</label>
                            <select name="status" id="edit_status" class="form-control" required>
                                <option value="" selected="selected">Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>                            
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputName">Test Description</label>
                            <textarea id="description" name="description" class="form-control" placeholder="Enter description" required>{{ old('description') }}</textarea>
                            @error('description')
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
    $(document).on('click', '#editBtn', function() {
    var url = $(this).data('url'); 
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            if(response.status === 'success') {
                var test = response.data;
                $('#id').val(test.id);
                $('#edit_test_name').val(test.test_name);
                $('#description').val(test.description);
                
                $('#edit_status').val(test.status).trigger('change');

                $('#editGroupModal').modal('show');
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
        $('#editMedicalTestForm').on('submit', function(event) {
            event.preventDefault();

            var formData = {
                _token: '{{ csrf_token() }}',
                test_id: $('#id').val(),
                test_name: $('#edit_test_name').val(),
                status: $('#edit_status').val(), // Ensure status is included
                description: $('#description').val()
            };

            $.ajax({
                url: '{{ route('dashboard.update.medical-test') }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        setTimeout(function() {
                            window.location.href = '{{ route('dashboard.medical-test-list') }}';
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    let message = "Something went wrong. Please try again later.";

                    // Handle Laravel validation errors
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        message = Object.values(xhr.responseJSON.errors)
                            .map(error => error[0])
                            .join('\n');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message,
                    });
                }
            });
        });
    });
</script>