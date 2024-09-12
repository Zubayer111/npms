@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @include("backend.components.admin.admin-list")
    @include("backend.components.admin.create-admin")
    @include("backend.components.admin.edit-user")
@endsection