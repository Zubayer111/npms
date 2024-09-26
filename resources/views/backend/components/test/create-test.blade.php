<div class="modal fade" id="createTest" tabindex="-1" role="dialog" aria-labelledby="createTestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="createTest">Create Test</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include your form here -->
                <form id="createTestForm"  method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputName">Test Name</label>
                            <input name="test_name" type="text" id="test_name" class="form-control" value="{{ old('test_name') }}" id="name" placeholder="Enter test name" required>
                            <span id="diseaseNameError" style="color: red;"></span>
                            @error('test_name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputName">Test Description</label>
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
        $('#test_name').on('keyup', function() {
            var testName = $(this).val();
            $.ajax({
                url: '{{ route("dashboard.medical-test-check-name") }}',
                type: 'GET',
                data: { test_name: testName },
                success: function(response) {
                    if (response.exists) {
                        $('#diseaseNameError').text('This test name is already taken.');
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
            $('#createTestForm').on('submit', function(event) {
                event.preventDefault();

                $.ajax({
                    url: '{{ route('dashboard.create.medical-test') }}',
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
                                window.location.href = '{{ route('dashboard.medical-test-list') }}';
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


