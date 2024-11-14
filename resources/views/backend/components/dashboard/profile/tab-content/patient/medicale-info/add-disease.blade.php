<div class="modal fade" id="addDiseaseModal" tabindex="-1" role="dialog" aria-labelledby="addDiseaseModalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="addDiseaseModalLabel">Add Disease</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include your form here -->
                @if ($diseases->isEmpty())
                     <p>No data available</p>
                        @else
                        <div class="d-flex flex-wrap">
                             @foreach ($diseases->unique('disease_name') as $d)
                              <div class="p-2">
                                <a href="javascript:void(0);" data-disease-id="{{ $d->id }}" data-user-id="{{ $data->user_id }}" class="text-bold btn btn-success btn-sm submit-ajax">{{ $d->disease_name }}</a>
                             </div>
                                 @endforeach
                         </div>
                     @endif

                     <div class="card-footer col-md-12 justify-content-between">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                    </div>
            </div>
        </div>
    </div>
</div>
