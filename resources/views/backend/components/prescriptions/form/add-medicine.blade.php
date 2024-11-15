<form id="prescriptionForm">
    <!-- Patient Selection -->
    <div class="form-group">
        <label for="patientName">Patient Name</label>
        <select id="patientName" class="form-control">
            <option>---Select Patient---</option>
        </select>
    </div>

    <!-- Medicine Selection -->
    <div class="form-group">
        <label>Medicine Name</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="medicineType" id="predefined" checked>
            <label class="form-check-label" for="predefined">Predefined</label>
        </div>
        <div class="form-row">
            <div class="col-5" style="padding: 0px">
                <select class="form-control" id="medicineForm">
                    <option value=" ">Forms</option>
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
                <input type="text" class="form-control" placeholder="Medicine Name">
            </div>
        </div>
        <div class="form-check mt-2">
            <input class="form-check-input" type="radio" name="medicineType" id="custom">
            <label class="form-check-label" for="custom">Custom (Medicine Name)</label>
        </div>
        <input type="text" class="form-control mt-1" placeholder="Enter Medicine Name">
        <input type="text" class="form-control mt-1" placeholder="Enter Medicine Custom Dose">
    </div>

    <!-- Dose and Duration -->
    <div class="form-group">
        <label for="dose">Dose</label>
        <select id="dose" class="form-control">
            <option>---Select Dose---</option>
        </select>
    </div>
    <div class="form-group">
        <label for="duration">Duration</label>
        <div class="form-row">
            <div class="col-5" style="padding: 0px">
                <input type="text" class="form-control">
            </div>
            <div class="col-7" style="padding: 0px">
                <select class="form-control" id="medicineForm">
                    <option value=" ">Select Duration</option>
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
        <input type="text" id="instruction" class="form-control" placeholder="Enter Medicine Instruction">
    </div>
    <button type="button" class="btn btn-success">Add Medicine</button>
</form>