<div class="modal fade" id="createMedicineTypeModal" tabindex="-1" role="dialog" aria-labelledby="createMedicineTypeModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="createMedicineTypeModal">Create Medicine Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createMedicineTypeForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputName">Medicine Type Name</label>
                            <input name="type_name" type="text" id="type_name" class="form-control" value="{{ old('type_name') }}" id="name" placeholder="Enter medicine type name" required>
                            <span id="medicineNameError" style="color: red;"></span>
                            @error('type_name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputName">Medicine Type Description</label>
                            <textarea name="description" class="form-control" placeholder="Enter description" required>{{ old('description') }}</textarea>
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

  <script type="text/javascript">
    $(document).ready(function() {
        $('#type_name').on('keyup', function() {
            var typeName = $(this).val();
            $.ajax({
                url: '{{ route("dashboard.check.medicine-type-name") }}',
                type: 'GET',
                data: { type_name: typeName },
                success: function(response) {
                    if (response.exists) {
                        $('#medicineNameError').text('This medicine type name is already taken.');
                        $('#submit').attr('disabled', true);
                    } else {
                        $('#medicineNameError').text('');
                        $('#submit').attr('disabled', false);
                    }
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
            $('#createMedicineTypeForm').on('submit', function(event) {
                event.preventDefault();

                $.ajax({
                    url: '{{ route('dashboard.create.medicine-type') }}',
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
                                window.location.href = '{{ route('dashboard.medicine-type-list') }}';
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





