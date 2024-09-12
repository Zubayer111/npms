@extends("backend.layouts.sidenav-layout")

@section("page_content")
@include("backend.components.dashboard.profile.medical-document.doc-list")
@include("backend.components.dashboard.profile.medical-document.uplade-doc")
@include("backend.components.dashboard.profile.medical-document.image-show")

@endsection