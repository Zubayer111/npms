@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @include("backend.components.test.test-list")
    @include("backend.components.test.create-test")
    @include("backend.components.test.edit-test")
    @include("backend.components.test.view-test")
@endsection