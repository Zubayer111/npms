<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>New Prescriptions</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">New Prescriptions</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      
      <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create Prescriptions</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Prescription Form -->
                            <div class="col-md-3">
                                @include("backend.components.prescriptions.form.add-medicine")
                            </div>
    
                            <!-- Medicine List Table -->
                            <div class="col-md-6">
                              <div id="prescriptionsContainer" class="table-responsive">
                                  <table class="table table-sm table-bordered">
                                      <thead>
                                          <tr>
                                              <th>SL</th>
                                              <th>Medicine</th>
                                              <th>Dose</th>
                                              <th>Duration</th>
                                              <th>Instruction</th>
                                              <th>Delete</th>
                                          </tr>
                                      </thead>
                                      <tbody id="medicineList">
                                          <!-- Rows will be dynamically populated here -->
                                      </tbody>
                                      
                                  </table>
                              </div>
                          </div>
                          
    
                            <!-- Additional Information -->
                            <div class="col-md-3">
                                @include("backend.components.prescriptions.form.additional-info")
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
  </div>

  <script>
    $('#prescriptionForm').on('submit', function(e) {
    e.preventDefault();

    let formData = $(this).serialize();

    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
        beforeSend: function () {
                $('#medicineList').html(`<img src="{{ asset('assets/images/ajax-loader.gif') }}">`);
            },
        success: function(response) {
            $('#medicineList').html(response.html);

            // Reset the form
            // $('#prescriptionForm')[0].reset();
            $('#medicine_type').val('');
            $('#medicine_name').val('');
            $('#dose').val('');
            $('#custom_medicine_name').val('');
            $('#custom_dose').val('');
            $('#duration_unit').val('');
            $('#instruction').val('');
        },
        error: function(xhr) {
            toastr.error('An error occurred. Please try again.', 'Error');
        }
    });
  });
  $(document).ready(function() {
        $('#patientRecordForm').on('submit', function(e) {

            e.preventDefault(); // Prevent the default form submission

            let formData = $(this).serialize(); // Serialize the form data
            var id = $("#patientName").val();
            console.log(id);
            $.ajax({
                url: $(this).attr('action'), // Form action URL
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    // Show a loading spinner or disable the submit button
                    console.log('Submitting...');
                },
                success: function(response) {
                    // Display a success message
                    toastr.success('Record added successfully.', 'Success');
                    
                    // Clear the form
                    $('#patientRecordForm')[0].reset();
                    
                    // Optionally update the UI with new data
                    console.log(response);
                },
                error: function(xhr) {
                    // Handle errors
                    toastr.error('An error occurred. Please check your input and try again.', 'Error');
                    
                    console.error(xhr.responseJSON);
                }
            });
        });
    });

    $(document).ready(function () {
    // Function to fetch and update medicine list
    function loadMedicineList() {
        $.ajax({
            url: '{{ route('dashboard.display-prescritions-medicine') }}', // Replace with your route URL
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content') // Add CSRF token if needed
            },
            beforeSend: function () {
                $('#medicineList').html(`<img src="{{ asset('assets/images/ajax-loader.gif') }}">`);
            },
            success: function (response) {
                // Populate the medicine list
                $('#medicineList').html(response.html);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching medicine list:", error);
            }
        });
    }

    // Call the function to load the medicine list initially
    loadMedicineList();
});


            
  </script>
  