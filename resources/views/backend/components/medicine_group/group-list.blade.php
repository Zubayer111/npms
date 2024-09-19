<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Medicine Group Tables</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/dashboard/home')}}">Home</a></li>
                <li class="breadcrumb-item active">Medicine Group List</li>
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
                  <h3 class="card-title">Medicine Group List</h3>
                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <div class="input-group-append">
                        <button type="button" class="btn btn-primary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#createMedicineGroupModal">
                          Create Medicine Group
                      </button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="group_table" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Group Name</th>
                        <th>Description</th>
                        <th>Status</th>
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
      function confirmDelete(id) {
          Swal.fire({
              title: 'Delete Medicine Group!',
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

<script type="text/javascript">
  $(document).ready(function() {
      $('#group_table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('dashboard.get-medicine-group-list') }}",

          columns: [
              {"data" : "id"},
              {"data" : "group_name"},
              {"data" : "description"},
              {"data" : "status"},
              {"data" : "action", orderable: false, searchable: false},
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