@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @include("backend.components.medicine_group.group-list")
    @include("backend.components.medicine_group.create-group")
    @include("backend.components.medicine_group.edit-group")
@endsection