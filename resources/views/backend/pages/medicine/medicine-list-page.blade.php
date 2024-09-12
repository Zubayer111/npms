@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @include("backend.components.medicine.medicine-list")
    @include("backend.components.medicine.create-medicine")
    {{-- @include("backend.components.medicine.edit-medicine") --}}
@endsection