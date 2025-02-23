<div class="tab-pane" id="treatments">
    <div class="timeline timeline-inverse">
        <section class="content">
            <!-- Search Section -->
            
        
            <!-- Table Section -->
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
        </section>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dashboard.patient-prescritions-list') }}",
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
