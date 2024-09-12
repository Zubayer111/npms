<div class="modal fade" id="upladeDoc" tabindex="-1" role="dialog" aria-labelledby="upladeDocModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="upladeDocModal">Upload Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="upladeDocForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="file_name">File Name</label>
                            <input name="file_name" type="text" class="form-control" id="file_name" required>
                            @error('file_name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="exampleInputName">Upload</label>
                            <input name="files[]" type="file" class="form-control"  id="name" multiple  required>
                            @error('files')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                          <label>File Type</label>
                          <select name="file_type" class="form-control select2" style="width: 100%;" required>
                            <option value="" selected="selected">Select File Type</option>
                            <option value="image">Image</option>
                            <option value="pdf">Pdf</option>
                            <option value="doc">Doc</option>
                            <option value="zip">Zip</option>
                          </select>
                          @error('file_type')
                          <p class="text-danger">{{ $message }}</p>
                          @enderror
                        </div>
                        
                    </div>
                    <div class="card-footer col-md-12 justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#upladeDocForm').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission
    
            // Create a FormData object to handle file uploads
            let formData = new FormData(this);
    
            $.ajax({
                url: '{{ route('dashboard.medical-documents') }}',
                type: 'POST',
                data: formData,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            setTimeout(function() {
                                window.location.href = '{{ route('dashboard.medical-documents-page') }}';
                            }, 2000);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            })
                        }
    
                    $('#upladeDoc').modal('hide');
    
                    $('#upladeDocForm')[0].reset();
                },
                error: function (xhr) {
                    // Handle error response
                    let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'An error occurred while uploading the files.';
    
                    // Show error message using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            });
        });
    });
    </script>