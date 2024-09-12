@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @if (session('type') == 'Admin')
    @include("backend.components.dashboard.profile.edit.admin-profile-edit")
    @elseif(session('type') == 'Company')
    @include("backend.components.dashboard.profile.edit.company-profile-edit")
    @elseif(session('type') == 'Doctor')
    @include("backend.components.dashboard.profile.edit.doctor-profile-edit")
    @elseif(session('type') == 'Patient')
    @include("backend.components.dashboard.profile.edit.patient-profile-edit")
    @endif
    
@endsection