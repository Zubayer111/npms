<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Deleted Patient List Tables</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Deleted Patient List</li>
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
                  <h3 class="card-title">Deleted Patient List</h3>
    
                  {{-- <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <div class="input-group-append">
                        <a href="{{url("/dashboard/create-user")}}" class="btn btn-primary">
                            <div>Create User</div>
                        </a>
                      </div>
                    </div>
                  </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="user_table" class="table text-nowrap table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Type</th>
                          <th>Status</th>
                          <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
      </section>
    </div>

    <script>
      function restore(id) {
          Swal.fire({
              title: 'Restore User!',
              text: "Are you sure you want to restore?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, restore it!'
          }).then((result) => {
              if (result.isConfirmed) {
                  document.getElementById('restore-form-' + id).submit();
              }
          })
      }
    </script>


<script type="text/javascript">
  $(document).ready(function() {
      $('#user_table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('dashboard.deleted-patient-list') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email'},
              {data: 'phone', name: 'phone'},
              {data: 'type', name: 'type'},
              {data: 'status', name: 'status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
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