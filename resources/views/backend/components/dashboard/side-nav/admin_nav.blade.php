<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{asset("assets/dist/img/AdminLTELogo.png")}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">NPMS</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset("assets/dist/img/user2-160x160.jpg")}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <h4 class="text-bold text-white">
          {{ session()->get('name') }}
      </h4>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="{{url("/dashboard/home")}}" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
        <li class="nav-item">
          <a href="{{url("/dashboard/user-list")}}" class="nav-link">
            <i class="nav-icon fa-solid fa-user"></i>
            <p>
             All User List 
            </p>
          </a>
        </li>
        {{-- admin --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-user-tie"></i>
            <p>
              Admin
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url("/dashboard/admin-list")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Admin List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/active-admin")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Active Admin</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/inactive-admin")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inactive Admin</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/deleted-admin")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Deleted Admin</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- doctor --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-user-doctor"></i>
            <p>
              Doctor
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url("/dashboard/doctor-list")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Doctor</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/active-doctor")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Active Doctor</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/inactive-doctor")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inactive Doctor</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/deleted-doctor")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Deleted Doctor</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- company --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-building"></i>
            <p>
              Company
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url("/dashboard/company-list")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Company</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/active-company")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Active Company</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/inactive-company")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inactive Company</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/deleted-company")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Deleted Company</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- patient --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-bed-pulse"></i>
            <p>
              Patient
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url("/dashboard/patient-list")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Patient</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/active-patient")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Active Patient</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/inactive-patient")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inactive Patient</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/deleted-patient")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Deleted Patient</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- Medicine Group --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-pills"></i>
            <p>
              Medicine Group
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url("/dashboard/medicine-group-list")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Medicine Group</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/active-medicine-group")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Active Medicine Group</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/inactive-medicine-group")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inactive Medicine Group</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/deleted-medicine-group")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Deleted Medicine Group</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- Medicine Type --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-pills"></i>
            <p>
              Medicine Type
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url("/dashboard/medicine-type-list")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Medicine Type</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/active-medicine-type")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Active Medicine Type</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/inactive-medicine-type")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inactive Medicine Type</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/deleted-medicine-type")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Deleted Medicine Type</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- Medicine --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-pills"></i>
            <p>
              Medicine
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url("/dashboard/medicine-list")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Medicine</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/active-medicine")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Active Medicine</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/inactive-medicine")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inactive Medicine</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/deleted-medicine")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Deleted Medicine</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- Diseases --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-disease"></i>
            <p>
              Diseases 
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url("/dashboard/disease-list")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Diseases </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/active-disease")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Active Diseases </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/inactive-disease")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inactive Diseases </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/deleted-disease")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Deleted Diseases </p>
              </a>
            </li>
          </ul>
        </li>
        {{-- medical test --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-vials"></i>
            <p>
              Medical Test 
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url("/dashboard/medical-test-list")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Test </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/active-medical-test")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Active Test </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/inactive-medical-test")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inactive Test </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/deleted-medical-test")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Deleted Test </p>
              </a>
            </li>
          </ul>
        </li>
        {{-- patient vendors --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-house-medical"></i>
            <p>
              Patient Vendors
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url("/dashboard/patient-vandor-list")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Patient Vendors</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/active-patient-vandor")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Active Patient Vendors </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/inactive-patient-vandor")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inactive Patient Vendors </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("/dashboard/deleted-patient-vandor")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Deleted Patient Vendors </p>
              </a>
            </li>
          </ul>
        </li>
        {{-- prescritions --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-prescription"></i>
            <p>
              Manage Prescritions
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url("/dashboard/new-prescritions")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>New Prescritions</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url("dashboard/prescritions-list")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Prescription</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- settings --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-cog"></i>
            <p>
              Settings
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url("/dashboard/active-log")}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Active Log</p>
              </a>
            </li>
            
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>