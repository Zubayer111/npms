<div class="row">
	<!-- Admin -->
	<div class="col-lg-3 col-6">
		<div class="small-box bg-info">
			<div class="inner">
				<h3>{{$adminCount}}</h3>
				<p>Total Admin</p>
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
		<div class="small-box bg-success">
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
		<div class="small-box" style="background: yellow">
			<div class="inner">
				<h3>{{$inActiveAdminCount}}</h3>
				<p>Inactive Admin</p>
			</div>
			<div class="icon">
				<i class="fa-solid fa-user-tie"></i>
			</div>
			<a href="{{url("dashboard/inactive-admin")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- ./col -->
</div>