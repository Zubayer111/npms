<div class="row">
	<!-- Admin -->
	<!-- Patient -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-info">
			<div class="inner">
				<h3>{{$patientCount}}</h3>
				<p>Total Patient</p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="{{url("dashboard/patient-list")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	
	<!-- active Doctor -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-success">
			<div class="inner">
				<h3>{{$activePatientCount}}</h3>
				<p>Active Patient</p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-user-doctor"></i>
			</div>
			<a href="{{url("dashboard/active-patient")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
    {{-- inactive doctor --}}
    <div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box" style="background: yellow">
			<div class="inner">
				<h3>{{$inActivePatientCount}}</h3>
				<p>Inactive Patient</p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-user-doctor"></i>
			</div>
			<a href="{{url("dashboard/inactive-patient")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- Patient -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-danger">
			<div class="inner">
				<h3>{{$deletedPatientCount}}</h3>
				<p>Deleted Patient</p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="{{url("dashboard/deleted-patient")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- Today Patient -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-success">
			<div class="inner">
				<h3>{{$todayPatientCount}}</h3>
				<p>Today Registered <br> Patient </p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
		</div>
	</div>
	<!-- ./col -->
</div>