
<div class="modal fade" id="editGroupModal" tabindex="-1" role="dialog" aria-labelledby="createMedicineGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="createMedicineGroupModalLabel">Edit Medicine Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editMedicineGroupForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="group_id" id="id">
                    <div class="form-group">
                        <label for="group_name">Medicine Group Name</label>
                        <input id="edit_group_name" name="group_name" type="text" class="form-control" value="{{ old('group_name') }}" placeholder="Enter group name" required>
                        <span id="groupNameError"></span>
                        @error('group_name')
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
                    <div class="form-group">
                        <label for="description">Medicine Group Description</label>
                        <textarea id="edit_description" name="description" class="form-control" placeholder="Enter description" required>{{ old('description') }}</textarea>
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

    $(document).on('click', '#editBtn', function() {
    var url = $(this).data('url'); 
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            if(response.status === 'success') {
                var group = response.data;
                $('#id').val(group.id);
                $('#edit_group_name').val(group.group_name);
                $('#edit_description').val(group.description);
                
                $('#edit_status').val(group.status).trigger('change');

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
        $('#editMedicineGroupForm').on('submit', function(event) {
            event.preventDefault();

            var formData = {
                _token: '{{ csrf_token() }}',
                group_id: $('#id').val(),
                group_name: $('#edit_group_name').val(),
                status: $('#edit_status').val(),
                description: $('#edit_description').val()
            };

            $.ajax({
                url: '{{ route('dashboard.update.group') }}',
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
                            window.location.href = '{{ route('dashboard.medicine-group-list') }}';
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



