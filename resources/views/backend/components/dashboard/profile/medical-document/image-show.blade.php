<div class="modal fade" id="documentModal" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="documentModalLabel">Document Viewer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body m-auto">
          <img id="documentImage" src="" class="img-fluid img-thumbnail" alt="Document Image">
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
  // Handle dynamic content for viewing documents
  $(document).on('click', '.viewBtn', function() {
    var url = $(this).data('url');

    // Update the modal image source
    $('#documentImage').attr('src', url);

    // Show the modal
    $('#documentModal').modal('show');
  });
});

</script>
    