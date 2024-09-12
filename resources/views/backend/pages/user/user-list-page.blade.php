@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @include("backend.components.user.user-list")
    @include("backend.components.user.create-user")
    @include("backend.components.user.edit-user")
@endsection