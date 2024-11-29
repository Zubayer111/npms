<a class="btn btn-sm btn-info mr-2"
    href="javascript:void(0);" onclick="openModal('{{ $row->asset_path }}')">
    View
</a>

<a class="btn btn-sm btn-success mr-2"
    href="{{ asset($row->asset_path) }}" download>
    Download
</a>

{{-- <a class="btn btn-sm btn-danger delete-faq"
    href="javascript:;;" data-id="{{ $row->id }}">
    Delete
</a> --}}

<a class="btn badge-danger btn-sm" onclick="confirmDelete({{ $row->id }})">Delete</a>

<form id="delete-form-{{ $row->id }}" action="{{ route('dashboard.medical-documents-delete', $row->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>


<div id="documentModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div id="modalContent"></div>
    </div>
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

<script>
    function openModal(url) {
        const modalContent = document.getElementById('modalContent');
        const extension = url.split('.').pop().toLowerCase();
    
        if (['png', 'jpg', 'jpeg', 'gif'].includes(extension)) {
            modalContent.innerHTML = `<img src="${url}" alt="Document" style="width:100%;">`;
        } else if (extension === 'pdf') {
            modalContent.innerHTML = `<iframe src="${url}" style="width:100%; height:500px;" frameborder="0"></iframe>`;
        } else if (['doc', 'docx'].includes(extension)) {
            modalContent.innerHTML = `<iframe src="https://docs.google.com/gview?url=${encodeURIComponent(url)}&embedded=true" style="width:100%; height:500px;" frameborder="0"></iframe>`;
        } else {
            modalContent.innerHTML = 'Unsupported file type.';
        }
    
        document.getElementById('documentModal').style.display = 'block';
    }
    
    function closeModal() {
        document.getElementById('documentModal').style.display = 'none';
    }
    </script>