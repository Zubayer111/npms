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
                        <form action="{{route('dashboard.patient.profile.update')}}" method="POST" enctype="multipart/form-data">
							@csrf
							@include('backend.components.dashboard.profile.edit.patient-profile-edit-form')
						</form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<script>
$(document).ready(function() {
	$('#email').on('keyup', function() {
		var email = $(this).val();
		var emailRegEx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

		if (email.length > 0) {
			if (!emailRegEx.test(email)) {
				$('#email-availability-status').html('<span class="text-danger">Invalid email format.</span>');
				$('#submit').prop('disabled', true);
			} else {
				$.ajax({
					url: '{{ route('check.email') }}',
					method: 'POST',
					data: {
						_token: '{{ csrf_token() }}',
						email: email
					},
					success: function(response) {
						if (response.exists) {
							$('#email-availability-status').html('<span class="text-danger">Email is already taken.</span>');
							$('#submit').prop('disabled', true);
						} else {
							$('#email-availability-status').html('<span class="text-success">Email is available.</span>');
							$('#submit').prop('disabled', false);
						}
					}
				});
			}
		} else {
			$('#email-availability-status').html('');
		}
	});
});

$(document).ready(function() {
	$('#phone').on('keyup', function() {
		var phone = $(this).val();

		$.ajax({
			url: '{{ route('check.phone') }}',
			type: 'POST',
			data: {
				phone: phone,
				_token: '{{ csrf_token() }}'
			},
			success: function(response) {
				if (response.status === 'success') {
					$('#result').html('<span class="text-success">Phone number is valid</span>');
					$('#submit').prop('disabled', false);
				} else {
					$('#result').html('<span class="text-danger">Phone number is not valid</span>');
					$('#submit').prop('disabled', true);
				}
			},
			error: function(xhr) {
				console.log(xhr.responseText);
			}
		});
	});
});
</script>