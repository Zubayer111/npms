<form action="" method="post">
    <div class="form-group">
        <label for="cc">C/C</label>
        <textarea class="form-control" id="cc" rows="2" style="max-width: 100%;"></textarea>
    </div>
    <div class="form-group">
        <label for="cf">C/F</label>
        <textarea class="form-control" id="cf" rows="2" style="max-width: 100%;"></textarea>
    </div>
    <div class="form-group">
        <label for="advice">Advice</label>
        <textarea class="form-control" id="advice" rows="2" style="max-width: 100%;"></textarea>
    </div>
    <div class="form-group">
        <label for="investigation">Investigation</label>
        <textarea class="form-control" id="investigation" rows="2" style="max-width: 100%;"></textarea>
    </div>
    <div class="form-group">
        <label for="nextVisit">Next Visiting Indications</label>
        <div class="form-row">
            <div class="col-md-5" style="padding: 0px">
                <input type="text" class="form-control">
            </div>
            <div class="col-md-7" style="padding: 0px">
                <select class="form-control" id="medicineForm">
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
        <textarea class="form-control" id="guide" rows="2" style="max-width: 100%;"></textarea>
    </div>
    <button type="button" class="btn btn-success">Save Prescription</button>
</form>