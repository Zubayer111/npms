<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Medicine Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Medicine</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
  
    <!-- Main content -->
    <section class="content">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Edit Medicine</h3>
            </div>
            <div class="editMedicineForm">
                <form id="MedicineForm" action="{{route("dashboard.update.medicine")}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputName">Medicine Name</label>
                            <input name="medicine_name" type="text" id="medicine_name" class="form-control" value="{{ $medicine->medicine_name }}" id="name" placeholder="Enter medicine name" required>
                            <span id="medicineNameError" style="color: red;"></span>
                            @error('medicine_name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="text" name="id" value="{{ $medicine->id }}" hidden>
                        <div class="form-group col-md-6">
                            <label>Manufacturer Name</label>
                            <select name="manufacturer_id" class="form-control select2bs4" style="width: 100%;" required>
                                <option value="" selected="selected" disabled>Select Manufacturer Name</option>
                                @foreach ($companys as $c)
                                    @if ($c->id == null)
                                        <option value="" disabled>No Manufacturer</option>
                                    @else
                                        <option value="{{ $c->id }}" {{ old('manufacturer_id', $medicine->manufacturer_id ) == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('manufacturer_id')
                            <p class="text-danger">Group Manufacturer Name Required</p>
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
                                        <option value="{{ $c->id }}" {{ old('brand_id', $medicine->brand_id ) == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('group_id')
                            <p class="text-danger">Brand Name Required</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputName">Use For</label>
                            <input name="use_for" type="text" id="use_for" class="form-control" value="{{ $medicine->use_for }}" id="use_for" placeholder="Enter use for" required>
                            @error('use_for')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputName">Price</label>
                            <input name="price" type="number" id="price" class="form-control" value="{{ $medicine->price }}" id="price" placeholder="Enter price" required>
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
                                        <option value="{{ $g->id }}" {{ old('group_id', $medicine->group_id) == $g->id ? 'selected' : '' }}>
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
                            <input name="strength" type="text" class="form-control" value="{{ $medicine->strength }}" id="strength" placeholder="Enter strength example: 10mg" required>
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
                                    <option value="{{ $type->id }}" {{ old('type_id', $medicine->type_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->type_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_id')
                            <p class="text-danger">Medicine Type Required</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control " style="width: 100%;" required>
                              <option value="" selected="selected">Select Status</option>
                              <option value="active" {{ $medicine->status == 'active' ? 'selected' : '' }}>Active</option>
                              <option value="inactive" {{ $medicine->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                          </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputName">Medicine Description</label>
                            <textarea name="description" class="form-control" placeholder="Enter description" required>{{ $medicine->description }}</textarea>
                            @error('description')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer col-md-12 justify-content-between">
                        <button type="button" class="btn btn-danger" onclick="window.location.href='{{ url('dashboard/medicine-list') }}'">Cancel</button>
                        <button type="submit" class="btn btn-success float-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

  <script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
        $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    });
</script>


{{-- <script>
    $(document).ready(function () {
        $('#medicineForm').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this); // Get form data

            $.ajax({
                url: "{{ route('dashboard.update.medicine') }}",
                type: "POST",
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
                    // Handle error and display error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update medicine. Please try again.',
                        showConfirmButton: true
                    });
                }
            });
        });
    });
</script> --}}