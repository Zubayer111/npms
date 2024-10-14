<div class="row justify-content-md-center">
    <div class="col-lg-12 col-12">
        <label for="name" class="text-black-50">Basic Info</label>
    </div>
</div>
    <input type="hidden" name="id" value="{{ $user ? $user->id : '' }}">
<div class="row justify-content">
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="title" class="font-weight-normal">Title</label>
            <select class="form-control" name="title">
                <option value="" selected="selected">Select Title</option>
                <option value="Mr." {{ $user && $user->title == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                <option value="Mrs." {{ $user && $user->title == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
            </select>
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="first_name" class="font-weight-normal">First Name<span class="text-red"> *</span></label>
            <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" type="text" name="first_name" value="{{ old('first_name', isset($user) ? $user->first_name : null) }}">
            @if($errors->has('first_name'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('first_name') }}</span>
            @endif
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="middle_name" class="font-weight-normal">Middle Name</label>
            <input class="form-control" type="text" name="middle_name" value="{{ old('middle_name', isset($user) ? $user->middle_name : null) }}">
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="last_name" class="font-weight-normal">Last Name<span class="text-red"> *</span></label>
            <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text" name="last_name" value="{{ old('last_name', isset($user) ? $user->last_name : null) }}">
            @if($errors->has('last_name'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('last_name') }}</span>
            @endif
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="email" class="font-weight-normal">Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email', isset($user) ? $user->email : null) }}">
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="phone_number" class="font-weight-normal">Phone Number<span class="text-red"> *</span></label>
            <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="text" name="phone_number" id="phone_number" min="10" value="{{ old('phone_number', isset($user) ? $user->phone_number : null) }}" readonly>
            @if($errors->has('phone_number'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('phone_number') }}</span>
            @endif
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="dob" class="font-weight-normal">Date of Birth<span class="text-red"> *</span></label>
            <input class="form-control {{ $errors->has('dob') ? 'is-invalid' : '' }}" type="date" name="dob" value="{{ old('dob', isset($user) && $user->dob ? $user->dob->format('Y-m-d') : '') }}">
            @if($errors->has('dob'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('dob') }}</span>
            @endif
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="gender" class="font-weight-normal">Gender<span class="text-red"> *</span></label>
            <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender">
                <option value="" selected="selected">Select Gender</option>
                <option value="Male" {{ $user && $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $user && $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ $user && $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @if($errors->has('gender'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('gender') }}</span>
            @endif
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="marital_status" class="font-weight-normal">Marital Status</label>
            <select class="form-control" name="marital_status">
                <option value="" selected="selected">Select Marital Status</option>
                <option value="Married" {{ $user && $user->marital_status == 'Married' ? 'selected' : '' }}>Married</option>
                <option value="Unmarried" {{ $user && $user->marital_status == 'Unmarried' ? 'selected' : '' }}>Unmarried</option>
                <option value="Separated" {{ $user && $user->marital_status == 'Separated' ? 'selected' : '' }}>Separated</option>
                <option value="Widowed" {{ $user && $user->marital_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                <option value="Single" {{ $user && $user->marital_status == 'Single' ? 'selected' : '' }}>Single</option>
                <option value="Life Partner" {{ $user && $user->marital_status == 'Life Partner' ? 'selected' : '' }}>Life Partner</option>
            </select>
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="blood_group" class="font-weight-normal">Blood Group</label>
            <select class="form-control" name="blood_group">
                <option value="" selected="selected">Select Blood Group</option>
                <option value="A+" {{ $user && $user->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                <option value="A-" {{ $user && $user->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                <option value="B+" {{ $user && $user->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                <option value="B-" {{ $user && $user->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                <option value="O+" {{ $user && $user->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                <option value="O-" {{ $user && $user->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
                <option value="AB+" {{ $user && $user->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                <option value="AB-" {{ $user && $user->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
            </select>
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="smoking_status" class="font-weight-normal">Smoking Status</label>
            <select class="form-control" name="smoking_status">
                <option value="" selected="selected">Select Smoking Status</option>
                <option value="smoker" {{ $user && $user->smoking_status == 'smoker' ? 'selected' : '' }}>Smoker</option>
                <option value="non smoker" {{ $user && $user->smoking_status == 'non smoker' ? 'selected' : '' }}>Non Smoker</option>
            </select>
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="alcohole_status" class="font-weight-normal">Alcohole Status</label>
            <select class="form-control" name="alcohole_status">
                <option value="" selected="selected">Select Alcohole Status</option>
                <option value="alcoholic" {{ $user && $user->alcohole_status == 'alcoholic' ? 'selected' : '' }}>Alcoholic</option>
                <option value="non alcoholic" {{ $user && $user->alcohole_status == 'non alcoholic' ? 'selected' : '' }}>Non Alcoholic</option>
            </select>
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="economical_status" class="font-weight-normal">Economical Status</label>
            <select class="form-control" name="economical_status">
                <option value="" selected="selected">Select Economical Status</option>
                <option value="rich" {{ $user && $user->economical_status == 'rich' ? 'selected' : '' }}>Rich</option>
                <option value="middle class" {{ $user && $user->economical_status == 'middle class' ? 'selected' : '' }}>Middle Class</option>
                <option value="poor" {{ $user && $user->economical_status == 'poor' ? 'selected' : '' }}>Poor</option>
            </select>
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="height" class="font-weight-normal">Height</label>
            <input class="form-control" type="number" name="height" value="{{ old('height', isset($user) ? $user->height : null) }}">
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="weight" class="font-weight-normal">Weight</label>
            <input class="form-control" type="number" name="weight" value="{{ old('weight', isset($user) ? $user->weight : null) }}">
        </div>
    </div>
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="bmi" class="font-weight-normal">BMI</label>
            <input class="form-control" type="number" step="0.01" name="bmi" value="{{ old('bmi', isset($user) ? $user->bmi : null) }}">
        </div>
    </div>
    {{-- <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="reference_by" class="font-weight-normal">Reference By</label>
            <input class="form-control" type="text" name="reference_by" value="{{ old('reference_by', isset($user) ? $user->reference_by : null) }}">
        </div>
    </div> --}}
    <div class="col-lg-3 col-3">
        <div class="form-group">
            <label for="reference_time" class="font-weight-normal">Reference Time</label>
            <input class="form-control" type="date" name="reference_time" value="{{ old('reference_time', isset($user) && $user->reference_time ? $user->reference_time->format('Y-m-d') : '') }}">
        </div>
    </div>
</div>
<hr/>


<div class="row justify-content-md-center">
    <div class="col-lg-12 col-12">
        <label for="name" class="text-black-50">Address</label>
    </div>
</div>

<div class="row justify-content">
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="address_one" class="font-weight-normal">Present Address</label>
            <input class="form-control" type="text" name="address_one" value="{{ old('address_one', isset($user) ? $user->address_one : null) }}">
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="address_two" class="font-weight-normal">Permanent Address</label>
            <input class="form-control" type="text" name="address_two" value="{{ old('address_two', isset($user) ? $user->address_two : null) }}">
        </div>
    </div>
    <div class="col-lg-4 col-2">
        <div class="form-group">
            <label for="city" class="font-weight-normal">City</label>
            <input class="form-control" type="text" name="city" value="{{ old('city', isset($user) ? $user->city : null) }}">
        </div>
    </div>

    <div class="col-lg-4 col-2">
        <div class="form-group">
            <label for="state" class="font-weight-normal">State</label>
            <input class="form-control" type="text" name="state" value="{{ old('state', isset($user) ? $user->state : null) }}">
        </div>
    </div>
    <div class="col-lg-4 col-2">
        <div class="form-group">
            <label for="name" class="font-weight-normal">Zip Code</label>
            <input class="form-control" type="number" name="zipCode" value="{{ old('zipCode', isset($user) ? $user->zipCode : null) }}">
        </div>
    </div>

</div>
<hr/>


<div class="row justify-content-md-center">
    <div class="col-lg-12 col-12">
        <label for="name" class="text-black-50">Others Info</label>
    </div>
</div>

<div class="row justify-content">
    <div class="col-lg-4 col-4">
        <div class="form-group">
            <label for="name" class="font-weight-normal">History</label>
            <textarea name="history" class="form-control">{{$user->history ?? ''}}</textarea>
        </div>
    </div>
    <div class="col-lg-4 col-4">
        <div class="form-group">
            <label for="name" class="font-weight-normal">Employer Details</label>
            <textarea name="employer_details" class="form-control">{{$user->employer_details ?? ''}}</textarea>
        </div>
    </div>
    <div class="col-lg-4 col-4">
        <div class="form-group">
            <label for="name" class="font-weight-normal">Reference Note</label>
            <textarea name="reference_note" class="form-control">{{$user->reference_note ?? ''}}</textarea>
        </div>
    </div>
</div>


<div class="row justify-content-md-center">
    <div class="col-lg-12 col-12">
        <label for="name" class="text-black-50">Profile Photo</label>
    </div>
</div>

<div class="row justify-content">
    <div class="col-lg-10 col-10">
        <div class="form-group">
            <label for="profile_photo" class="font-weight-normal">Profile Photo</label>
            <input class="form-control" type="file" name="profile_photo">
            <input type="hidden" name="file_path" value="{{ $user->profile_photo ?? '' }}">
        </div>
    </div>
    <div class="col-lg-2 col-2 text-center">
            @if ($user && $user->profile_photo) 
            <img style="width: 100px; height: 100px; border-radius: 50%;" src="{{ asset($user->profile_photo) }}" alt="User profile picture"> 
            @else 
            <img style="width: 100px; height: 100px; border-radius: 50%;" src="{{ asset('assets/dist/img/image-not-found.png') }}" alt="Image not found">
            @endif 
    </div>
</div>

<div class="row justify-content-center" style="margin-top: 20px;">
    <div class="col-lg-6 col-6">
        <a class="btn btn-default" href="{{route('dashboard.profile')}}">
            Back
        </a>
    </div>
    <div class="col-lg-6 col-6">
        <div class="form-group ">
            <button class="btn btn-danger float-right" type="submit">
                Update
            </button>
        </div>
    </div>

</div>
