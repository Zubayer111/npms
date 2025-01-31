<div class="tab-pane" id="medical-info">
    <div class="timeline timeline-inverse">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title">Info List</h3>
                            
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- Left Column with Health Indicators -->
                                    <div class="col-lg-5 col-md-5 col-sm-12" style="border-right: 2px solid #D4AF37; padding: 10px;">
                                        <div class="card-tools">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary btn-sm mb-2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#addDiseaseModal">
                                                        <div>Add Disease</div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-info">
                                            <p class="text-bold text-white text-center">Patient Illness</p>
                                        </div>
                                        
                                        <div class="row" id="illness-list">
                                            <!-- This will be dynamically populated by AJAX -->
                                        </div>
                                        @include('backend.components.dashboard.profile.tab-content.patient.medicale-info.add-disease')
                                    </div>
                                    
                            
                                    <!-- Right Column with Table and Add Button -->
                                    <div class="col-lg-7 col-md-7 col-sm-12" style="padding: 20px;">
                                        <table id="complain_table" class="table table-bordered table-hover w-100">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Complain</th>
                                                    <th>Created By</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                            
                                        <!-- ADD Button -->
                                        <div style="text-align: right; margin-top: 20px;">
                                            <button type="button" id="addComplain" class="btn btn-primary btn-sm" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#addComplainModal">ADD</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            
        </section>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        var patientId = {{ $data->user_id }}; 
        var url = "{{ route('dashboard.patient.complain-list', ':id') }}";
        url = url.replace(':id', patientId);

        $('#complain_table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: url,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'complain', name: 'complain'},
                {data: 'created_by', name: 'created_by'},
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

  
      function confirmDelete(id) {
          Swal.fire({
              title: 'Delete User!',
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
<script>
    $(document).ready(function() {
    var patientId = {{ $data->user_id }}; // Get patient ID from Blade

    loadIllnessList(patientId); // Load illness list on page load

    // Add illness (GET Method)
    $(document).on('click', '.submit-ajax', function(e) {
        e.preventDefault();
        var diseaseId = $(this).data('disease-id');
        var userId = $(this).data('user-id');

        var url = "{{ route('dashboard.add-patient-ilnase', [':id', ':pid']) }}";
        url = url.replace(':id', diseaseId).replace(':pid', userId) + "?_=" + new Date().getTime(); // Prevent caching

        $.ajax({
            url: url,
            type: 'GET', // Using GET method
            success: function(response) {
                if (response.status === "success") {
                    loadIllnessList(userId); // Refresh illness list
                } else {
                    alert('Failed to add illness. Please try again.');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Something went wrong. Please try again.');
            }
        });
    });

    // Remove illness
    $(document).on('click', '.remove-illness', function(e) {
        e.preventDefault();
        var $this = $(this);
        var illnessId = $this.data('id');

        $this.addClass('disabled').text('Processing...').prop('disabled', true);

        var url = '{{ route("dashboard.remove-patient-ilnase", ":id") }}'.replace(':id', illnessId) + "?_=" + new Date().getTime();

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.status === "success") {
                    loadIllnessList(patientId);
                } else {
                    alert('Failed to remove illness. Please try again.');
                    $this.removeClass('disabled').prop('disabled', false).text('Remove');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('An error occurred while removing the illness');
                $this.removeClass('disabled').prop('disabled', false).text('Retry');
            }
        });
    });

    // Restore illness
    $(document).on('click', '.restore-illness', function(e) {
        e.preventDefault();
        var $this = $(this);
        var illnessId = $this.data('id');

        $this.addClass('disabled').text('Restoring...').prop('disabled', true);

        var url = '{{ route("dashboard.restore-patient-ilnase", ":id") }}'.replace(':id', illnessId) + "?_=" + new Date().getTime();

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.status === "success") {
                    loadIllnessList(patientId);
                } else {
                    alert('Failed to restore illness. Please try again.');
                    $this.removeClass('disabled').prop('disabled', false).text('Restore');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('An error occurred while restoring the illness');
                $this.removeClass('disabled').prop('disabled', false).text('Retry');
            }
        });
    });

    // Fetch illness list
    function loadIllnessList(userId) {
        var url = '{{ route("dashboard.get-ilnase-list", ":id") }}'.replace(':id', userId) + "?_=" + new Date().getTime();

        $.ajax({
            url: url,
            type: 'GET',
            cache: false, // Ensure fresh data is fetched
            success: function(response) {
                if (response.status === "success") {
                    var illnessList = response.data;
                    var html = '';

                    if (illnessList.length > 0) {
                        $.each(illnessList, function(index, illness) {
                            html += '<div class="p-2">';
                            if (illness.deleted_at === null) {
                                html += '<a href="javascript:void(0);" class="btn btn-success btn-sm remove-illness" data-id="' + illness.id + '">' + illness.disease.disease_name + '</a>';
                            } else {
                                html += '<a href="javascript:void(0);" class="btn btn-danger btn-sm restore-illness" data-id="' + illness.id + '">' + illness.disease.disease_name + '</a>';
                            }
                            html += '</div>';
                        });
                    } else {
                        html = '<p>No data available</p>';
                    }
                    $('#illness-list').html(html);
                }
            },
            error: function(xhr) {
                alert('Something went wrong while fetching the illness list.');
                console.log(xhr.responseText);
            }
        });
    }
});

</script>

