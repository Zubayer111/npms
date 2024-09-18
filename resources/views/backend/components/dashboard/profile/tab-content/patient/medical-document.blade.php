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
                            <table id="document_table" class="table table-bordered table-hover w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>File Name</th>
                                        <th>File Type</th>
                                        <th>File Extension</th>
                                        <th>File Uploaded</th>
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
                                                <option value="medical_report">Medical Report</option>
                                                <option value="prescription">Prescription</option>
                                                <option value="other">Other</option>
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

<script type="text/javascript">
$(document).ready(function() {
    $('#document_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('dashboard.medical-documents-list') }}",
        columns: [
            {
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'file_name'},
            {data: 'file_type'},
            {data: 'file_extension'},
            {data: 'created_at'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ],
        order: [[0, 'desc']],
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });
});
</script>

<script>
$(document).ready(function() {
    $('#uploadDocumentForm').on('submit', function(event) {
        event.preventDefault();
        let formData = new FormData(this);
        resetValidationErrors();
        
        $.ajax({
            url: '{{ route('dashboard.medical-documents') }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
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
                if (errors) {
                    Object.keys(errors).forEach(function(field) {
                        let inputField = $(`[name="${field}"]`);
                        inputField.addClass('is-invalid');
                        inputField.after(`<span class="invalid-feedback" role="alert">${errors[field][0]}</span>`);
                    });
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please check the form for errors.',
                });
            }
        });
    });

    // Add event listener for modal close
    $('#uploadDocumentModal').on('hidden.bs.modal', function () {
        resetValidationErrors();
        $('#uploadDocumentForm')[0].reset();
    });

    // Function to reset validation errors
    function resetValidationErrors() {
        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid');
    }
});
</script>