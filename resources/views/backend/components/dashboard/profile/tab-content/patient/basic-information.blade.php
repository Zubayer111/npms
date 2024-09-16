<div class="active tab-pane" id="basic-information">
	<!-- Post -->
	<div class="post">
		<div class="user-block">
			<div class="row">
				<div class="col-md-6">
					<h5 class="text-bold">First Name :</h5>
					<p class="text-muted">{{$data->first_name ?? "No user data available"}}</p>
				</div>
				<div class="col-md-6">
					<h5 class="text-bold">Middile Name :</h5>
					<p class="text-muted">{{$data->middle_name ?? "No user data available"}}</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<h5 class="text-bold">Last Name :</h5>
					<p class="text-muted">{{$data->last_name ?? "No user data available"}}</p>
				</div>
				<div class="col-md-6">
					<h5 class="text-bold">Email :</h5>
					<p class="text-muted">{{$data->user->email ?? "No user data available"}}</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<h5 class="text-bold">Phone :</h5>
					<p class="text-muted">{{$data->phone_number ?? "No user data available"}}</p>
				</div>
				<div class="col-md-6">
					<h5 class="text-bold">Present Address :</h5>
					<p class="text-muted">{{$data->address_one ?? "No user data available"}}</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h5 class="text-bold">Perment Address :</h5>
				<p class="text-muted">{{$data->address_two ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">City :</h5>
				<p class="text-muted">{{$data->city ?? "No user data available"}}</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<h5 class="text-bold">State :</h5>
				<p class="text-muted">{{$data->state ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">Zip Code :</h5>
				<p class="text-muted">{{$data->zipCode ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">Reference Time:</h5> @if ($data) <p class="text-muted">{{ $data->reference_time ? $data->reference_time->format('F d, Y') : "No user data available" }}</p> @else <p class="text-muted">No user data available</p> @endif
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">Gender :</h5>
				<p class="text-muted">{{$data->gender ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">Marital Status :</h5>
				<p class="text-muted">{{$data->marital_status ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">Date of Birth:</h5> @if ($data && $data->dob) <p class="text-muted">{{ $data->dob->format('F d, Y') }}</p> @else <p class="text-muted">No user data available</p> @endif
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">Height :</h5>
				<p class="text-muted">{{$data->height ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">Weight :</h5>
				<p class="text-muted">{{$data->weight ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">BMI :</h5>
				<p class="text-muted">{{$data->bmi ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">Blood Group :</h5>
				<p class="text-muted">{{$data->blood_group ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">Economical Status :</h5>
				<p class="text-muted">{{$data->economical_status ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">Smoking Status :</h5>
				<p class="text-muted">{{$data->smoking_status ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">Alcoholed Status :</h5>
				<p class="text-muted">{{$data->alcohole_status ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">History :</h5>
				<p class="text-muted">{{$data->history ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">Employer Details :</h5>
				<p class="text-muted">{{$data->employer_details ?? "No user data available"}}</p>
			</div>
			<div class="col-md-6">
				<h5 class="text-bold">Reference Note :</h5>
				<p class="text-muted">{{$data->reference_note ?? "No user data available"}}</p>
			</div>
		</div>
	</div>
</div>