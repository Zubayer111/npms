<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Docment List Tables</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Docment List</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      
      <section class="content">
        <div class="row">
            <div class="col-12 ">
              <div class="card ">
                <div class="card-header">
                  <h3 class="card-title">Docment List</h3>
                  <div class="card-tools">
                    <div class="input-group input-group-sm">
                      <div class="input-group-append">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#upladeDoc">
                          <div>Upload Docment</div>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="doc_table" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>File Name</th>
                        <th>Uplode Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
      </section>
</div>


<script type="text/javascript">
    $(document).ready(function() {
    var table = $('#doc_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('dashboard.medical-documents-list') }}",
            type: "GET",
            error: function(xhr, error, thrown) {
                console.error("Error occurred: ", xhr.responseText); 
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'file_name', name: 'file_name'},
            {data: 'created_at', name: 'created_at'
                , render: function (data, type, row) {
                    return moment(data).format('DD.MMMM.YYYY');
                }
            },
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: [[0, 'desc']],
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
    });
});
</script>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete Docment!',
            text: "Are you sure you want to delete?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
  </script>
  