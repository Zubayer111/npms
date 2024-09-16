<div class="card-body box-profile">
    <div class="text-center">
        @if ($data && $data->profile_photo)
            <img class="profile-user-img img-fluid img-circle" style="height: 100px" src="{{ asset($data->profile_photo) }}" alt="User profile picture">
        @else
            <img class="profile-user-img img-fluid img-circle" style="height: 100px" src="{{ asset('assets/dist/img/image-not-found.png') }}" alt="Image not found">
        @endif
    </div>
    
    <h3 class="profile-username text-center">
        {{ $data->first_name ?? 'No user data available' }} {{ $data->middle_name ?? '' }} {{ $data->last_name ?? '' }}
    </h3>

    <p class="text-muted text-center">Patient</p>
    <a href="{{ route('dashboard.patient.profile.edit') }}" class="btn btn-primary btn-block"><b>Edit</b></a>
</div>