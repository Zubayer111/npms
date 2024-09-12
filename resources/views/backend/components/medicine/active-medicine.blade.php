<div class="content-wrapper">
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Active Medicine List Tables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Active Medicine List</li>
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
                <h3 class="card-title">Active Medicine List</h3>
                {{-- <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div class="input-group-append">
                      <a href="{{url("/dashboard/create-medicine-group")}}" class="btn btn-primary">
                          <div>Create Medicine Group</div>
                      </a>
                    </div>
                  </div>
                </div> --}}
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="medicine_table" class="table table-responsive table-bordered table-hover" >
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Medicine Name</th>
                      <th>Manufacturer</th>
                      <th>Brand Name</th>
                      <th>Medicine Group Name</th>
                      <th>Medicine Type</th>
                      <th>Strength</th>
                      <th>Price</th>
                      <th>Use For</th>
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
  </script>


<script type="text/javascript">
  $(document).ready(function() {
      $('#medicine_table').DataTable({
        
          processing: true,
          serverSide: true,
          ajax: "{{ route('dashboard.active-medicine-list') }}",
          columns: [
              {"data" : "id"},
              {"data" : "medicine_name"},
              {"data" : "manufacturer.name"},
              {"data" : "brand.name"},
              {"data" : "type.type_name"},
              {"data" : "group.group_name"},
              {"data" : "strength"},
              {"data" : "price"},
              {"data" : "use_for"},
              {"data" : "description"},
              {"data" : "status"},
              {"data" : "action", orderable: false, searchable: false},
          ],
          //  responsive: true,
          order: [[0, 'desc']],
           autoWidth: false
          
      });
  });
</script>