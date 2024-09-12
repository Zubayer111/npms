@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @include("backend.components.patient_vendors.vandor-list")
    @include("backend.components.patient_vendors.create-vandor")
    @include("backend.components.patient_vendors.edit-vandor")
    @include("backend.components.patient_vendors.view-vandor")
@endsection