<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Inactive Doctor List Tables</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Inactive Doctor List</li>
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
                  <h3 class="card-title">Inactive Doctor List</h3>
    
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
                  <table id="user_table" class="table table-bordered table-hover">
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
                    <tbody></tbody>
                    {{-- @foreach ($doctors as $d)
                    <tbody>
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$d->name}}</td>
                        <td>{{$d->email}}</td>
                        <td>{{$d->phone}}</td>
                        <td>Doctor</td>
                        <td><span class="tag tag-success">Inactive</span></td>
                        <td >
                          <form id="active-form-{{ $d->id }}" action="{{route('dasboard.user-active', $d->id)}}" method="get">
                            @csrf
                            
                          </form>
                            <button class="btn badge-success btn-sm" onclick="confirmActive({{ $d->id }})">Active</button>
                        </td>
    
                      </tr>
                    </tbody>
                    @endforeach --}}
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
              title: 'Active User!',
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
      $('#user_table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('dashboard.inactive-doctor-list') }}",
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