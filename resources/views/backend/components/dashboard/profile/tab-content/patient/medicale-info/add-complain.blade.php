<div class="modal fade" id="addComplainModal" tabindex="-1" role="dialog" aria-labelledby="addComplainModallLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="addComplainModalLabel">Add Complain</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include your form here -->
                <form  id="addComplainForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="complain">Write Complain :</label>
                        <textarea class="form-control" name="complain" id="complain" rows="3"></textarea>
                        @error('complain')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="card-footer col-md-12 justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success float-right" id="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#addComplainForm').on('submit', function(event) {
            event.preventDefault();
            
            $("#submit").prop('disabled', true);
            $("#submit").text('Please wait...');
            
            $.ajax({
                url: '{{ route('dashboard.patient.add-complain', $data->user_id) }}', 
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("#submit").prop('disabled', false);
                    $("#submit").text('Submit');
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        $('#addComplainModal').modal('hide');
                        
                        $('#addComplainForm')[0].reset();
                        
                        $('#complain_table').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                        });
                        $("#submit").prop('disabled', false);
                        $("#submit").text('Submit');
                    }
                },
                error: function(response) {
                    let errors = response.responseJSON;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errors.message || 'An error occurred.',
                    });
                    $("#submit").prop('disabled', false);
                    $("#submit").text('Submit');
                }
            });
        });
    });
</script>
