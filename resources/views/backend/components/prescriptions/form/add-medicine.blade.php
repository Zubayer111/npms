<form id="prescriptionForm" action="{{route("dashboard.add-prescritions-medicine")}}" method="post">
    @csrf
    <!-- Patient Selection -->
    <div class="form-group">
        <label for="patientName">Patient Name</label>
        <select class="form-control patient-search" id="patient_id" name="patient_id" required>
            <option value="">---Select Patient---</option>
            @foreach ($patients as $patient)
                <option value="{{ $patient->id }}">
                    {{ $patient->title }} {{ $patient->first_name }} {{ $patient->last_name }}
                </option>
            @endforeach
        </select>
        
    </div>

    <!-- Medicine Selection -->
    <div class="form-group">
        <label>Medicine Name</label>
        <div class="form-check">
            <input class="form-check-input"  type="radio" name="medicineType"  id="predefined" checked onchange="toggleMedicineType();">
            <label class="form-check-label" for="predefined">Predefined</label>
        </div>
        <div class="form-row">
            <div class="col-5" style="padding: 0px">
                <select class="form-control" name="medicine_type" id="medicine_type" required>
                    <option value="">Forms</option>
                    <option value="1">Tab</option>
                    <option value="1">Cap</option>
                    <option value="3">Cream</option>
                    <option value="11">E/E Drop</option>
                    <option value="11">Ear Drop</option>
                    <option value="11">Eye Drop</option>
                    <option value="3">Gel</option>
                    <option value="9">Hair Spray</option>
                    <option value="10">Inhaler</option>
                    <option value="4">Inj</option>
                    <option value="3">Lotion</option>
                    <option value="8">Nasal Drop</option>
                    <option value="8">Nasal Spray</option>
                    <option value="14">Nebulization</option>
                    <option value="3">Oint</option>
                    <option value="7">Oral Paste</option>
                    <option value="12">Paediatric Drop</option>
                    <option value="15">Sachet</option>
                    <option value="5">Shampoo</option>
                    <option value="13">Sol</option>
                    <option value="10">Spray</option>
                    <option value="2">Suppository</option>
                    <option value="6">Susp</option>
                    <option value="6">Syrup</option>
                </select>
            </div>
            <div class="col-7" style="padding: 0px">
                <input type="text" class="form-control" id="medicine_name" name="medicine_name" placeholder="Medicine Name" required>
            </div>
        </div>
        <div class="form-group">
            <label for="dose">Dose</label>
            <select id="dose" name="dose" class="form-control" required>
                <option value="">---Select Dose---</option>
            </select>
            <div id="dose_result"></div>
        </div>
        <div class="form-check mt-2">
            <input class="form-check-input" type="radio" name="medicineType" id="custom" onchange="toggleMedicineType();">
            <label class="form-check-label" for="custom">Custom (Medicine Name)</label>
        </div>
        <input type="text" id="custom_medicine_name" name="medicine_name" class="form-control mt-1" placeholder="Enter Medicine Name" disabled>
        <input type="text" id="custom_dose" name="cust_dose" class="form-control mt-1" placeholder="Enter Medicine Custom Dose" disabled>
    </div>
   
    <!-- Dose and Duration -->
    
    <div class="form-group">
        <label for="duration">Duration</label>
        <div class="form-row">
            <div class="col-5" style="padding: 0px">
                <input id="duration_unit" type="text" name="duration" class="form-control" placeholder="Enter Duration" required>
            </div>
            <div class="col-7" style="padding: 0px">
                <select id="duration_unit" class="form-control" name="duration_unit" id="medicineForm" required>
                    <option value="">Select Duration</option>
                    <option value="দিন">দিন</option>
                    <option value="সপ্তাহ">সপ্তাহ</option>
                    <option value="মাস">মাস</option>
                    <option value="চলবে">চলবে</option>
                </select>
            </div>
            
        </div>
    </div>

    <!-- Instructions and Add Button -->
    <div class="form-group">
        <label for="instruction">Medicine Instruction</label>
        <input type="text" name="instruction" id="instruction" class="form-control" placeholder="Enter Medicine Instruction" required>
    </div>
    <button type="submit" class="btn btn-success">Add Medicine</button>
</form>

<div class="col-md-6">
    
</div>




<script>
$(document).ready(function() {
    $('.patient-search').select2({
        placeholder: "---Select Patient---",
        allowClear: true,
        theme: 'bootstrap4'
    });
});


    function toggleMedicineType() {
            const isPredefined = document.getElementById('predefined').checked;
    
            // Enable or disable predefined fields
            document.getElementById('medicine_type').disabled = !isPredefined;
            document.getElementById('medicine_name').disabled = !isPredefined;
            document.getElementById('dose').disabled = !isPredefined; // Ensure "Select Dose" is controlled
    
            // Enable or disable custom fields
            document.getElementById('custom_medicine_name').disabled = isPredefined;
            document.getElementById('custom_dose').disabled = isPredefined;
        }

    $("#medicine_type").change(function (event) {
    event.preventDefault();
    var medicineTypeId = $(this).val();

    if (medicineTypeId) { // Ensure a value is selected
        $.ajax({
            url: "{{ route('dashboard.doses-by-type', '') }}/" + medicineTypeId,
            type: "GET",
            beforeSend: function () {
                $('#dose_result').html(`<img src="{{ asset('assets/images/ajax-loader.gif') }}">`);
            },
            success: function (data) {
                // Clear existing options in the dose dropdown
                $('#dose').empty().append('<option value="">---Select Dose---</option>');

                // Populate new options dynamically
                data.forEach(function (dose) {
                    $('#dose').append(`<option class="form-control text-muted text-sm" value="${dose.dose_name}">${dose.dose_name}</option>`);
                });

                $('#dose_result').html(''); // Clear the loader
            },
            error: function (xhr) {
                $('#ajax_message').hide().html('There was an error while fetching the data.').fadeIn(500);
            }
        });
    } else {
        $('#dose').empty().append('<option>---Select Dose---</option>'); // Reset dose dropdown
        $('#dose_result').html('');
    }
});


</script>














