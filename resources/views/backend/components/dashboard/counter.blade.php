<div class="row">
	<!-- Admin -->
	<div class="col-lg-3 col-6">
		<div class="small-box bg-info">
			<div class="inner">
				<h3>{{$adminCount}}</h3>
				<p>Admin</p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-user-tie"></i>
			</div>
			<a href="{{url("dashboard/admin-list")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- active Admin -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-info">
			<div class="inner">
				<h3>{{$activeAdminCount}}</h3>
				<p>Active Admin</p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-user-tie"></i>
			</div>
			<a href="{{url("dashboard/active-admin")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- Doctor -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-success">
			<div class="inner">
				<h3>{{$doctorCount}}</h3>
				<p>Doctor</p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-user-doctor"></i>
			</div>
			<a href="{{url("dashboard/doctor-list")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- active Doctor -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-success">
			<div class="inner">
				<h3>{{$activeDoctorCount}}</h3>
				<p>Active Doctor</p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-user-doctor"></i>
			</div>
			<a href="{{url("dashboard/active-doctor")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- Today Doctor -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-success">
			<div class="inner">
				<h3>{{$todayDoctorCount}}</h3>
				<p>Today Registered <br> Doctor </p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-user-doctor"></i>
			</div>
			{{-- <a href="{{url("dashboard/active-doctor")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a> --}}
		</div>
	</div>
	<!-- Patient -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-warning">
			<div class="inner">
				<h3>{{$patientCount}}</h3>
				<p>Patient</p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="{{url("dashboard/patient-list")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- Today Patient -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-warning">
			<div class="inner">
				<h3>{{$todayPatientCount}}</h3>
				<p>Today Registered <br> Patient </p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			{{-- <a href="{{url("dashboard/patient-list")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a> --}}
		</div>
	</div>
	<!-- Company -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-danger">
			<div class="inner">
				<h3>{{$companyCount}}</h3>
				<p>Company</p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-building"></i>
			</div>
			<a href="{{url("dashboard/company-list")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- active Company -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-danger">
			<div class="inner">
				<h3>{{$activeCompanyCount}}</h3>
				<p> Active Company</p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-building"></i>
			</div>
			<a href="{{url("dashboard/active-company")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- ./col -->
</div>