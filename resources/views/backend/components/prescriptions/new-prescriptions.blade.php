<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>New Prescriptions</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">New Prescriptions</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      
      <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create Prescriptions</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Prescription Form -->
                            <div class="col-md-3">
                                @include("backend.components.prescriptions.form.add-medicine")
                            </div>
    
                            <!-- Medicine List Table -->
                            <div class="col-md-6">
                                @include("backend.components.prescriptions.table.medicine-list")
                            </div>
    
                            <!-- Additional Information -->
                            <div class="col-md-3">
                                @include("backend.components.prescriptions.form.additional-info")
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
  </div>
  