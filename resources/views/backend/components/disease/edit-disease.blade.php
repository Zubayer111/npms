<div class="modal fade" id="editDisease" tabindex="-1" role="dialog" aria-labelledby="createDiseaseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="editDisease">Edit Disease</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include your form here -->
                <form id="editDiseaseForm"  method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body row">
                        <input type="hidden" name="disease_id" id="id" value="">
                        <div class="form-group col-md-6">
                            <label for="exampleInputName">Disease Name</label>
                            <input name="disease_name" type="text" id="edit_disease_name" class="form-control" value="{{ old('disease_name') }}" placeholder="Enter disease name" required>
                            <span id="diseaseNameError" style="color: red;"></span>
                            @error('disease_name')
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
                        <div class="form-group col-md-12">
                            <label for="exampleInputName">Disease Description</label>
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
                var disease = response.data;
                $('#id').val(disease.id);
                $('#edit_disease_name').val(disease.disease_name);
                $('#description').val(disease.description);
                
                $('#edit_status').val(disease.status).trigger('change');

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
        $('#editDiseaseForm').on('submit', function(event) {
            event.preventDefault();

            var formData = {
                _token: '{{ csrf_token() }}',
                disease_id: $('#id').val(),
                disease_name: $('#edit_disease_name').val(),
                status: $('#edit_status').val(), // Ensure status is included
                description: $('#description').val()
            };

            $.ajax({
                url: '{{ route('dashboard.update.disease') }}',
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
                            window.location.href = '{{ route('dashboard.disease-list') }}';
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