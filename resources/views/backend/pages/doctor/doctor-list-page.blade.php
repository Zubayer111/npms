@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @include("backend.components.doctor.doctor-list")
    @include("backend.components.doctor.create-doctor")
    @include("backend.components.doctor.edit-user")
@endsection