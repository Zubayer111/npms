@extends("backend.layouts.app")

@section("content")
  @include("backend.components.dashboard.top-nav")
  @if (session('type') == 'Admin')
  @include("backend.components.dashboard.side-nav.admin_nav")
  @elseif ( session('type') == 'Company'  )
  @include("backend.components.dashboard.side-nav.company_nav")
  @elseif ( session('type') == 'Doctor')
  @include("backend.components.dashboard.side-nav.doctor_nav")
  @elseif ( session('type') == 'Patient')
  @include("backend.components.dashboard.side-nav.patient_nav")
  @endif

  @yield("page_content")

  @include("backend.components.dashboard.footer")
@endSection