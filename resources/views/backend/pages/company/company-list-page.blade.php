@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @include("backend.components.company.company-list")
    @include("backend.components.company.create-company")
    @include("backend.components.company.edit-user")
@endsection