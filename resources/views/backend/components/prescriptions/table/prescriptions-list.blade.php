<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>All Prescriptions List Tables</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">All Prescriptions List</li>
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
                  <h3 class="card-title">All Prescriptions List</h3>
    
                  
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="user_table" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Created Date</th>
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
      $('#user_table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('dashboard.get-prescritions-list') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'patient_name', name: 'patient_name'},
              {data: 'created_at', name: 'created_at'},
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