<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Log List Tables</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Log List</li>
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
                  <h3 class="card-title">Log List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="log_table" class="table table-bordered table-hover" >
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Log Name</th>
                        <th>Log Description</th>
                        <th>Log Time</th>
                        <th>Log User</th>
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
  
    {{-- <script>
      function confirmDelete(id) {
          Swal.fire({
              title: 'Delete Medicine !',
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
      function confirmInactive(id) {
            Swal.fire({
                title: 'Deactivate Medicine !',
                text: "Are you sure you want to deactivate?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, deactivate it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('inactive-form-' + id).submit();
                }
            })
        }
    </script> --}}
  
  
    <script>
        $(document).ready(function() {
            $('#log_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.active-log-list') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'log_name', name: 'log_name' }, // Ensure 'log_name' exists in DB
                    { data: 'log_description', name: 'log_description' },
                    { data: 'log_time', name: 'log_time' },
                    { data: 'log_user', name: 'log_user' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }

                ]
                ,order: [[0, 'desc']],
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
        });
    </script>
    