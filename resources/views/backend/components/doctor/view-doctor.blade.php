<div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
      </div><!-- /.container-fluid -->
    </section>
  
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
  
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  @if ($data && $data->profile_photo)
                      <img class="profile-user-img img-fluid img-circle" src="{{ asset($data->profile_photo) }}" alt="User profile picture">
                  @else
                      <img class="profile-user-img img-fluid img-circle" src="{{ asset('assets/dist/img/avatar.png') }}" alt="Default profile picture">
                  @endif
                </div>
                
                <h3 class="profile-username text-center">{{$data->first_name ?? 'No user data available'}} {{$data->middle_name ?? ''}} {{$data->last_name ?? ''}}</h3>
  
                <p class="text-muted text-center">Doctor</p>
  
                
  
                <a href="{{route('dashboard.doctor.admin.edit-profile',["id" => $data->id])}}" class="btn btn-primary btn-block"><b>Edit</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
  
            <!-- About Me Box -->
            
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Basic Information</a></li>
                  {{-- <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li> --}}
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Security</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
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
                          <p class="text-muted">{{$data->zip_code ?? "No user data available"}}</p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <h5 class="text-bold">Degree :</h5>
                          <p class="text-muted">{{$data->degree ?? "No user data available"}}</p>
                        </div>
                        <div class="col-md-6">
                          <h5 class="text-bold">Speciality :</h5>
                          <p class="text-muted">{{$data->speciality ?? "No user data available"}}</p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <h5 class="text-bold">Organization :</h5>
                          <p class="text-muted">{{$data->organization ?? "No user data available"}}</p>
                        </div>
                        
                      </div>
                    </div>
                    
                  </div>
                  
                    <!-- /.post -->
                  
                  <!-- /.tab-pane -->
                  {{-- <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>
  
                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 12:05</span>
  
                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
  
                          <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-user bg-info"></i>
  
                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>
  
                          <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                          </h3>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-comments bg-warning"></i>
  
                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>
  
                          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
  
                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-camera bg-purple"></i>
  
                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 2 days ago</span>
  
                          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
  
                          <div class="timeline-body">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div> --}}
                  <!-- /.tab-pane -->
  
                  <div class="tab-pane" id="settings">
                    <form action="{{route('dashboard.update-password')}}" class="form-horizontal" method="POST">
                      @csrf
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input name="password" type="password" class="form-control" id="inputName" placeholder="Password" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Comfirm Password</label>
                        <div class="col-sm-10">
                          <input name="confirm_password" type="password" class="form-control" id="inputEmail" placeholder="Comfirm Password" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          {{-- <button type="submit" class="btn btn-secondary">Cancel</button> --}}
                          <button type="submit" class="btn btn-primary float-right">Submit</button>
  
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>