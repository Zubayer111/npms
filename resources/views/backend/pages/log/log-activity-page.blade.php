@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @include("backend.components.log.activity_log_content")
    @include("backend.components.log.view_log")
@endsection