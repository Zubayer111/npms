<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Update Patient Profile</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item">
							<a href="#">Home</a>
						</li>
						<li class="breadcrumb-item active">Update Patient Profile</li>
					</ol>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
        <div class="row ">
            <div class="col-lg-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            Update Patient Profile
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
							@csrf
							@include('backend.components.dashboard.profile.edit.patient-profile-edit-form')
						</form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>