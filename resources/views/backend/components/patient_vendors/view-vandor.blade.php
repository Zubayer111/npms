<!-- Modal for Viewing Patient Vendor -->
<div class="modal fade" id="viewPatientVandorModal" tabindex="-1" role="dialog" aria-labelledby="viewPatientVandorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="viewPatientVandorModalLabel">View Patient Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded dynamically via JavaScript -->
                <p id="patientVendorDetails">Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        // Handle click on View button
        $(document).on('click', '#viewBtn', function () {
            var url = $(this).data('url'); // Get the URL from the button's data attribute
    
            // AJAX request to fetch the patient vendor's details
            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    if (response.status === 'success') {
                        // Properly access the nested data object
                        var data = response.data;
                        $('#patientVendorDetails').html(`
                            <p><strong>Name:</strong> ${data.name}</p>
                            <p><strong>Email:</strong> ${data.email}</p>
                            <p><strong>Phone:</strong> ${data.phone}</p>
                            <p><strong>Address:</strong> ${data.address}</p>
                            <p><strong>Fax:</strong> ${data.fax}</p>
                            
                        `);
                        // Show the modal after loading the data
                        $('#viewPatientVandorModal').modal('show');
                    } else {
                        $('#patientVendorDetails').html('<p>An error occurred while fetching data.</p>');
                    }
                },
                error: function (xhr) {
                    console.error('An error occurred:', xhr.responseText);
                    $('#patientVendorDetails').html('<p>An error occurred while fetching data.</p>');
                }
            });
        });
    });
</script>
    
