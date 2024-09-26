<div class="modal fade" id="createDisease" tabindex="-1" role="dialog" aria-labelledby="createDiseaseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="createDisease">Create Disease</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include your form here -->
                <form id="createDiseaseForm"  method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputName">Disease Name</label>
                            <input name="disease_name" type="text" id="disease_name" class="form-control" value="{{ old('disease_name') }}" id="name" placeholder="Enter disease name" required>
                            <span id="diseaseNameError" style="color: red;"></span>
                            @error('disease_name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputName">Disease Description</label>
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
        $('#disease_name').on('keyup', function() {
            var diseaseName = $(this).val();
            $.ajax({
                url: '{{ route("dashboard.disease-check-name") }}',
                type: 'GET',
                data: { disease_name: diseaseName },
                success: function(response) {
                    if (response.exists) {
                        $('#diseaseNameError').text('This disease name is already taken.');
                        $('#submit').attr('disabled', true);
                    } else {
                        $('#diseaseNameError').text('');
                        $('#submit').attr('disabled', false);
                    }
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
            $('#createDiseaseForm').on('submit', function(event) {
                event.preventDefault();

                $.ajax({
                    url: '{{ route('dashboard.create.disease') }}',
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
                                window.location.href = '{{ route('dashboard.disease-list') }}';
                            }, 2000);
                        } 
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = 'Something went wrong. Please try again later.\n';
                        for (let key in errors) {
                            errorMessage += errors[key][0] + '\n';
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                        });
                    }
                });
            });
        });
</script>



