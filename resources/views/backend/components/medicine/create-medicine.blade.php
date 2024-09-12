
<div class="modal fade" id="createMedicine" tabindex="-1" role="dialog" aria-labelledby="createMedicineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="createMedicineModalLabel">Create Medicine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createMedicineForm" action="{{route("dashboard.create.medicine")}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputName">Medicine Name</label>
                            <input name="medicine_name" type="text" id="medicine_name" class="form-control" value="{{ old('medicine_name') }}" id="name" placeholder="Enter medicine name" required>
                            <span id="medicineNameError" style="color: red;"></span>
                            @error('medicine_name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Manufacturer Name</label>
                            <select name="manufacturer_id" class="form-control select2bs4" style="width: 100%;" required>
                                <option value="" selected="selected" disabled>Select Manufacturer</option>
                                @foreach ($companys as $c)
                                    @if ($c->id == null)
                                        <option value="" disabled>No Manufacturer</option>
                                    @else
                                    <option value="{{ $c->id }}" {{ old('group_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('manufacturer_id')
                            <p class="text-danger">Manufacturer Name Required</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Brand Name</label>
                            <select name="brand_id" class="form-control select2bs4" style="width: 100%;" required>
                                <option value="" selected="selected" disabled>Select Brand Name</option>
                                @foreach ($companys as $c)
                                    @if ($c->id == null)
                                        <option value="" disabled>No Brand</option>
                                    @else
                                    <option value="{{ $c->id }}" {{ old('brand_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('brand_id')
                            <p class="text-danger">Brand Name Required</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputName">Use For</label>
                            <input name="use_for" type="text" id="use_for" class="form-control" value="{{ old('use_for') }}" id="use_for" placeholder="Enter use for" required>
                            @error('use_for')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputName">Price</label>
                            <input name="price" type="number" id="price" class="form-control" value="{{ old('price') }}" id="price" placeholder="Enter price" required>
                            @error('price')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Group Name</label>
                            <select name="group_id" class="form-control select2bs4" style="width: 100%;" required>
                                <option value="" selected="selected" disabled>Select Group Name</option>
                                @foreach ($groups as $g)
                                    @if ($g->id == null)
                                        <option value="" disabled>No Group</option>
                                    @else
                                    <option value="{{ $g->id }}" {{ old('group_id') == $g->id ? 'selected' : '' }}>
                                        {{ $g->group_name }}
                                    </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('group_id')
                            <p class="text-danger">Group Name Required</p>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="exampleInputName">Strength</label>
                            <input name="strength" type="text" class="form-control" value="{{ old('strength') }}" id="strength" placeholder="Example: 10mg" required>
                            @error('power')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Medicine Type</label>
                            <select name="type_id" class="form-control select2bs4" style="width: 100%;" required>
                                <option value="" class="text-muted" selected="selected" disabled>Select Medicine Type</option>
                                @foreach ($medicineTypes as $type)
                                        @if ($type->id == null)
                                        <option value="" disabled>No Type</option>
                                    @endif
                                    <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->type_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_id')
                            <p class="text-danger">Medicine Type Required</p>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label for="exampleInputName">Medicine Description</label>
                            <textarea name="description" class="form-control" placeholder="Enter description" required>{{ old('description') }}</textarea>
                            @error('description')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="card-footer col-md-12 justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ url('dashboard/medicine-list') }}'">Cancel</button>
                        <button type="submit" class="btn btn-primary float-right" id="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(function () {
        $('.select2').select2();
        $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    });
</script>

  <script type="text/javascript">
    $(document).ready(function() {
        $('#medicine_name').on('keyup', function() {
            var medicineName = $(this).val();
            $.ajax({
                url: '{{ route("dashboard.check.medicine-name") }}',
                type: 'GET',
                data: { medicine_name: medicineName },
                success: function(response) {
                    if (response.exists) {
                        $('#medicineNameError').text('This medicine name is already taken.');
                        $('#submit').attr('disabled', true);
                    } else {
                        $('#medicineNameError').text('');
                        $('#submit').attr('disabled', false);
                    }
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#createMedicineForm').on('submit', function (e) {
            e.preventDefault(); 
    
            var formData = new FormData(this); 
    
            $.ajax({
                url: $(this).attr('action'), 
                type: 'POST',
                data: formData,
                processData: false, 
                contentType: false, 
                success: function (response) {
                    
                    if(response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            setTimeout(function() {
                                window.location.href = '{{ route('dashboard.medicine-list') }}';
                            }, 2000);
                    } 
                },
                error: function (xhr) {
                    var errors = xhr.responseJSON.errors;
                    $('.text-danger').remove(); 
    
                    if (errors) {
                        $.each(errors, function (key, value) {
                            var inputField = $('[name="' + key + '"]');
                            inputField.after('<span class="text-danger">' + value[0] + '</span>');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.message || 'Something went wrong!',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });
    });
    </script>
    
    


