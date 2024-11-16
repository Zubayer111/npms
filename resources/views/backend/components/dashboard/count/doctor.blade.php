<div class="row">
	<!-- Admin -->
	<div class="col-lg-3 col-6">
		<div class="small-box bg-info">
			<div class="inner">
				<h3>{{$doctorCount}}</h3>
				<p>Total Doctor</p>
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
    {{-- inactive doctor --}}
    <div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box" style="background: yellow">
			<div class="inner">
				<h3>{{$inActiveDoctorCount}}</h3>
				<p>Inactive Doctor</p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-user-doctor"></i>
			</div>
			<a href="{{url("dashboard/inactive-doctor")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
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
		</div>
	</div>
	<!-- ./col -->
</div>