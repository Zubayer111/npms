
<!-- Modal Structure -->
<div class="modal fade" id="createMedicineGroupModal" tabindex="-1" role="dialog" aria-labelledby="createMedicineGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="createMedicineGroupModalLabel">Create Medicine Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createMedicineGroupForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="group_name">Medicine Group Name</label>
                        <input id="group_name" name="group_name" type="text" class="form-control" value="{{ old('group_name') }}" placeholder="Enter group name" required>
                        <span id="groupNameError"></span>
                        @error('group_name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Medicine Group Description</label>
                        <textarea name="description" class="form-control" placeholder="Enter description" required>{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="card-footer col-md-12 justify-content-between">
                        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close" ><span class="btn btn-dark" aria-hidden="true">Cancel</span></button>
                        <button type="submit" class="btn btn-primary float-right" id="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#group_name').on('keyup', function() {
            var groupName = $(this).val();

            $.ajax({
                url: '{{ route("dashboard.check.group-name") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    group_name: groupName
                },
                success: function(response) {
                    if (response.exists) {
                        $('#groupNameError').html('This medicine group name is already taken.').css('color', 'red');
                        $('#submit').attr('disabled', true);
                    } else {
                        
                        $('#groupNameError').html('');
                        $('#submit').attr('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error occurred:', error); 
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
            $('#createMedicineGroupForm').on('submit', function(event) {
                event.preventDefault();

                $.ajax({
                    url: '{{ route('dashboard.create.group') }}',
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
                                window.location.href = '{{ route('dashboard.medicine-group-list') }}';
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
