@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @if (session('type') == 'Admin')
        @include("backend.components.dashboard.profile.admin-profile")
    @elseif(session('type') == 'Company')
        @include("backend.components.dashboard.profile.company-profile")
    @elseif(session('type') == 'Doctor')
        @include("backend.components.dashboard.profile.doctor-profile")
    @elseif(session('type') == 'Patient')
        @include("backend.components.dashboard.profile.patient-profile")
    @endif
    
@endsection