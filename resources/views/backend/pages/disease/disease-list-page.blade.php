@extends("backend.layouts.sidenav-layout")

@section("page_content")
    @include("backend.components.disease.disease-list")
    @include("backend.components.disease.create-disease")
    @include("backend.components.disease.edit-disease")
@endsection