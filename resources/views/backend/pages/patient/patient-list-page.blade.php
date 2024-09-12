@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @include("backend.components.patient.patient-list")
    @include("backend.components.patient.create-patient")
    @include("backend.components.patient.edit-user")
@endsection