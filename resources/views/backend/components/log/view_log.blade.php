<!-- Log Modal -->
<div class="modal fade" id="logViewModal" tabindex="-1" role="dialog" aria-labelledby="logViewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">View Log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 ">
                      <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">Log Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <p id="logInfo">Loading...</p>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
    $(document).on('click', '.view-btn', function (e) {
        e.preventDefault();

        var logId = $(this).data('id');
        var url = "/dashboard/log-view/" + logId; // Construct URL dynamically

        $('#logInfo').html('<p>Loading...</p>'); // Clear previous data

        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                console.log(response); // Debugging

                if (response.status === 'success') {
                    var data = response.data;
                    var attributes = data.attributes || {}; 

                    var attributesHtml = '<p><strong>Attributes:</strong></p>';
                    if ($.isEmptyObject(attributes)) {
                        attributesHtml += '<p>No additional attributes found.</p>';
                    } else {
                        // Loop through the attributes object and handle nested objects
                        $.each(attributes, function (key, value) {
                            // Mask password fields
                            if (key.toLowerCase().includes('password')) {
                                value = '*****'; // Mask the password field
                            }

                            // If the value is an object, stringify it
                            if (typeof value === 'object' && value !== null) {
                                value = JSON.stringify(value, null, 4);
                            }

                            attributesHtml += `<p><strong>${key}:</strong> ${value}</p>`;
                        });
                    }

                    $('#logInfo').html(`
                        <p><strong>Log Name:</strong> ${data.log_name}</p>
                        <p><strong>Description:</strong> ${data.description}</p>
                        <p><strong>Time:</strong> ${data.created_at}</p>
                        <p><strong>User:</strong> ${data.causer ? data.causer.name : 'System'}</p>
                        ${attributesHtml}
                    `);

                    $('#logViewModal').modal('show');
                } else {
                    $('#logInfo').html('<p>An error occurred while fetching data.</p>');
                }
            },
            error: function (xhr) {
                console.error('Error:', xhr.status, xhr.responseText); // Debugging
                $('#logInfo').html(`<p>Error ${xhr.status}: ${xhr.responseText}</p>`);
            }
        });
    });
});



</script>

