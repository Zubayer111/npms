<div class="row">
	<!-- Admin -->
	<div class="col-lg-3 col-6">
		<div class="small-box bg-info">
			<div class="inner">
				<h3>{{$companyCount}}</h3>
				<p>Total Company</p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-building"></i>
			</div>
			<a href="{{url("dashboard/company-list")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	
	<!-- active Doctor -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-success">
			<div class="inner">
				<h3>{{$activeCompanyCount}}</h3>
				<p>Active Company</p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-building"></i>
			</div>
			<a href="{{url("dashboard/active-company")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
    {{-- inactive doctor --}}
    <div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box" style="background: yellow">
			<div class="inner">
				<h3>{{$inActiveCompanyCount}}</h3>
				<p>Inactive Company</p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-building"></i>
			</div>
			<a href="{{url("dashboard/inactive-company")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- Today Doctor -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-success">
			<div class="inner">
				<h3>{{$todayCompanyCount}}</h3>
				<p>Today Registered <br> Company </p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-building"></i>
			</div>
		</div>
	</div>
	<!-- ./col -->
</div>