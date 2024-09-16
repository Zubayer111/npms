<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Profile</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">User Profile</li>
					</ol>
				</div>
			</div>
		</div>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3">
					<div class="card card-primary card-outline">
						@include("backend.components.dashboard.profile.card.patient-card")
					</div>
				</div>
				<div class="col-md-9">
					<div class="card">
						<div class="card-header p-2">
							<ul class="nav nav-pills">
								<li class="nav-item"><a class="nav-link active" href="#basic-information" data-toggle="tab">Basic Information</a></li>
								<li class="nav-item"><a class="nav-link" href="#medical-document" data-toggle="tab">Medical Document</a></li>
							</ul>
						</div>

						<div class="card-body">
							<div class="tab-content">
								@include("backend.components.dashboard.profile.tab-content.patient.basic-information")
								@include("backend.components.dashboard.profile.tab-content.patient.medical-document")
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script>
	function confirmDelete(id) {
		Swal.fire({
			title: 'Delete Medical Document!',
			text: "Are you sure you want to delete?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				document.getElementById('delete-form-' + id).submit();
			}
		});
	}
</script>