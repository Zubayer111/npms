<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Update Admin Profile Form</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Update Admin Profile</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Update Admin Profile</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body row">
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputName">First Name</label>
                    <input name="first_name" type="text" class="form-control" id="exampleInputName" placeholder="Enter first name" value="" required>
                </div>
                    
                
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Middle Name</label>
                    <input name="middle_name" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter middle name" value="" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputMobile">Last Name</label>
                  <input name="last_name" type="text" class="form-control" id="exampleInputMobile" placeholder="Enter last name" value="" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputMobile">Mobile Number</label>
                    <input name="phone_number" type="number" class="form-control" id="exampleInputMobile" placeholder="Enter mobile" value="" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputName">Present Address</label>
                    <input name="address_one" type="text" class="form-control" id="exampleInputName" placeholder="Enter present address" value="" required>
                </div>
                    
                
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Permanent Address</label>
                    <input name="address_two" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter permanent address" value="" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputMobile">City</label>
                  <input name="city" type="text" class="form-control" id="exampleInputMobile" placeholder="Enter city" value="" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputMobile">State</label>
                    <input name="state" type="text" class="form-control" id="exampleInputMobile" placeholder="Enter state" value="" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputMobile">Zip Code</label>
                    <input name="zip_code" type="text" class="form-control" id="exampleInputMobile" placeholder="Enter zip code" value="" required>
                </div>
            </div>
            
          <!-- /.card-body -->
          
          
          <div class="card-footer col-md-12 justify-content-between">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ url('dashboard/profile') }}'">Cancel</button>
            <button type="submit" class="btn btn-primary float-right">Submit</button>
        </div>
        </form>
        
      </div>
      </section>
</div>    