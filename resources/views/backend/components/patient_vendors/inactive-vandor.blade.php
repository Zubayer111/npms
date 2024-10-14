<div class="content-wrapper">
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Inactive Patient Vendor List Tables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Inactive Patient Vendor List</li>
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
                <h3 class="card-title">Inactive Patient Vendor List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="vandor_table" class="table table-responsive table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Fax</th>
                      <th>Address</th>
                      <th>Contact Person</th>
                      <th>Status</th>
                      <th>Token</th>
                        <th>Secret key</th>
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

<script>
  function confirmActive(id) {
      Swal.fire({
          title: 'Active Patient vandor Type!',
          text: "Are you sure you want to active?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, active it!'
      }).then((result) => {
          if (result.isConfirmed) {
              document.getElementById('active-form-' + id).submit();
          }
      })
  }
</script>


<script type="text/javascript">
  $(document).ready(function() {
      $('#vandor_table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('dashboard.inactive-patient-vandor-list') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email'},
              {data: 'phone', name: 'phone'},
              {data: 'fax', name: 'fax'},
              {data: 'address', name: 'address'},
              {data: 'contact_person', name: 'contact_person'},
              {data: 'status', name: 'status'},
              {data: 'token', name: 'token', render: function(data, type, row) {
                  return `<span class="text-break">${data}</span>`;
              }},
              {data: 'secret_key', name: 'secret_key', render: function(data, type, row) {
                  return `<span class="text-break">${data}</span>`;
              }},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          order: [[0, 'desc']],
          autoWidth: false
      });
  });
</script>