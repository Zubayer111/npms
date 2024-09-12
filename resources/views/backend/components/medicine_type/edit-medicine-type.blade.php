<div class="modal fade" id="editMedicineTypeModal" tabindex="-1" role="dialog" aria-labelledby="createMedicineTypeModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="createMedicineTypeModal">Edit Medicine Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editMedicineTypeForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body row">
                        <input type="text" name="type_id" id="id" hidden>
                        <div class="form-group col-md-6">
                            <label for="exampleInputName">Medicine Type Name</label>
                            <input name="type_name" type="text" id="edit_type_name" class="form-control" value="{{ old('type_name') }}" placeholder="Enter medicine type name" required>
                            <span id="medicineNameError" style="color: red;"></span>
                            @error('type_name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Status">Status</label>
                            <select name="status" id="edit_status" class="form-control" required>
                              <option value="" selected="selected">Select Status</option>
                              <option value="active">Active</option>
                              <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputName">Medicine Type Description</label>
                            <textarea id="edit_description" name="description" class="form-control" placeholder="Enter description" required>{{ old('description') }}</textarea>
                            @error('description')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="card-footer col-md-12 justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary float-right" id="submit">Submit</button>
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
                var type = response.data;
                $('#id').val(type.id);
                $('#edit_type_name').val(type.type_name);
                $('#edit_description').val(type.description);
                
                $('#edit_status').val(type.status).trigger('change');

                $('#editGroupModal').modal('show');
            }
        },
        error: function(xhr) {
            console.error("An error occurred: " + xhr.status + " " + xhr.statusText);
        }
    });
});

$(document).ready(function() {
        $('#editMedicineTypeForm').on('submit', function(event) {
            event.preventDefault();

            var formData = {
                _token: '{{ csrf_token() }}',
                type_id: $('#id').val(),
                type_name: $('#edit_type_name').val(),
                status: $('#edit_status').val(),
                description: $('#edit_description').val()
            };

            $.ajax({
                url: '{{ route('dashboard.update.medicine-type') }}',
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
                            window.location.href = '{{ route('dashboard.medicine-type-list') }}';
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