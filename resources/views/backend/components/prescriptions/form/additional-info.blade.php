<form action="{{route("dashboard.save-prescription")}}" method="post" id="patientRecordForm">
    @csrf
    <div class="form-group">
        <label for="cc">C/D</label>
        <textarea class="form-control" name="clinical_diagnosis" id="cc" rows="2" style="max-width: 100%;"></textarea>
    </div>
    <div class="form-group">
        <label for="cf">D/D</label>
        <textarea class="form-control" name="disease_description" id="cf" rows="2" style="max-width: 100%;"></textarea>
    </div>
    <div class="form-group">
        <label for="advice">Advice</label>
        <textarea class="form-control" name="advice" id="advice" rows="2" style="max-width: 100%;"></textarea>
    </div>
    <div class="form-group">
        <label for="investigation">Investigation</label>
        <textarea class="form-control" name="investigation" id="investigation" rows="2" style="max-width: 100%;"></textarea>
    </div>
    <div class="form-group">
        <label for="nextVisit">Next Visiting Indications</label>
        <div class="form-row">
            <div class="col-md-5" style="padding: 0px">
                <input type="text" name="next_meeting_date" class="form-control" placeholder="Enter a date">
            </div>
            <div class="col-md-7" style="padding: 0px">
                <select name="next_meeting_indication" class="form-control" id="medicineForm">
                    <option value="দিন পর যোগাযোগ করবেন।">দিন</option>
                    <option value="মাস পর যোগাযোগ করবেন।">মাস </option>
                    <option value="রিপোর্ট সহ যোগাযোগ করবেন।">রিপোর্ট সহ</option>
                    <option value="আরোগ্য হইলে প্রয়োজন নাই">প্রয়োজন নাই</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label for="guide">Guide to Previous Prescription</label>
        <textarea name="guide_to_prescription" class="form-control" id="guide" rows="2" style="max-width: 100%;"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Save Prescription</button>
</form>


<script>
    $(document).ready(function () {
    let isSubmitting = false;

    $('#patientRecordForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (isSubmitting) return; // Prevent duplicate submissions
        isSubmitting = true;

        let formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: "{{ route('dashboard.save-prescription') }}", // Backend route for saving
            method: "POST",
            data: formData,
            success: function (response) {
                isSubmitting = false; // Reset flag
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    showConfirmButton: true,
                    timer: 2000
                }).then(() => {
                    window.location.href = "{{ route('dashboard.prescritions-list') }}";
                });
            },
            error: function (xhr) {
                isSubmitting = false; // Reset flag
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "";
                    for (let key in errors) {
                        errorMessage += `- ${errors[key][0]}<br>`;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errorMessage,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred. Please try again later.',
                    });
                }
            }
        });
    });
});


</script>