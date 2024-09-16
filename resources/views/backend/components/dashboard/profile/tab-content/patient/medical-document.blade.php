<div class="tab-pane" id="medical-document">
    <div class="timeline timeline-inverse">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Document List</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadDocumentModal">
                                            <div>Upload Document</div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="user_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="uploadDocumentModal" tabindex="-1" role="dialog" aria-labelledby="uploadDocumentModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title" id="uploadDocumentModalLabel">Upload Document</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="uploadDocumentForm" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body row">
                                    <div class="col-lg-6 col-6">
                                        <div class="form-group">
                                            <label for="file_name" class="font-weight-normal">Document Name<span class="text-red"> *</span></label>
                                            <input class="form-control {{ $errors->has('file_name') ? 'is-invalid' : '' }}" type="text" name="file_name" id="file_name">
                                            @if($errors->has('file_name'))
                                                <span class="invalid-feedback" role="alert">{{ $errors->first('file_name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-6">
                                        <div class="form-group">
                                            <label for="gender" class="font-weight-normal">Document Type<span class="text-red"> *</span></label>
                                            <select class="form-control {{ $errors->has('file_type') ? 'is-invalid' : '' }}" name="file_type">
                                                <option value="" selected="selected">Select Document Type</option>
                                                <option value="image">Image</option>
                                                <option value="pdf">PDF</option>
                                                <option value="doc">DOC</option>
                                            </select>
                                            @if($errors->has('file_type'))
                                                <span class="invalid-feedback" role="alert">{{ $errors->first('file_type') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-12">
                                        <div class="form-group">
                                            <label for="file" class="font-weight-normal">Document</label>
                                            <input class="form-control" type="file" name="file">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer col-md-12 justify-content-between">
                                    <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close"><span class="btn btn-dark" aria-hidden="true">Cancel</span></button>
                                    <button type="submit" class="btn btn-primary float-right" id="submit">Upload Document</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#uploadDocumentForm').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: '{{ route('dashboard.medical-documents') }}',
            method: 'POST',
            data: $(this).serialize(),
            console.log("data::",data);
            success: function(response) {
                if(response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    });
                    setTimeout(function() {
                        window.location.href = '{{ route('dashboard.profile') }}';
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                    })
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
                    text: response.message,
                });
            }
        });
    });
});
</script>