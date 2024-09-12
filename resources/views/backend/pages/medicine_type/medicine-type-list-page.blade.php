@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @include("backend.components.medicine_type.medicine-type-list")
    @include("backend.components.medicine_type.create-medicine-type")
    @include("backend.components.medicine_type.edit-medicine-type")
@endsection