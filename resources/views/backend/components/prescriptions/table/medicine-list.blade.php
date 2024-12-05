@forelse ($allPrescriptions as $m)
<tr>
    <td class="text-center text-sm">{{ $loop->iteration }}</td>
    <td class="text-sm">{{ $m->name }}</td> <!-- Use $m->name for the medicine name -->
    <td class="text-sm">{{ $m->attributes->dose }}</td> <!-- Access custom attributes -->
    <td class="text-sm">{{ $m->attributes->duration }} {{ $m->attributes->duration_unit }}</td> <!-- Include duration unit -->
    <td class="text-sm">{{ $m->attributes->instruction }}</td>
    <td>
        <a href="#" class="btn btn-danger btn-sm delete-medicine" data-id="{{ $m->id }}">
            <i class="fa-solid fa-trash"></i>
        </a>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">No medicines added.</td>
</tr>
@endforelse


<script>
 $(document).on('click', '.delete-medicine', function (e) {
    e.preventDefault();

    let medicineId = $(this).data('id'); // Retrieve the medicine ID

    $.ajax({
        url: '{{ route('dashboard.remove-prescritions-medicine') }}', // Endpoint for the remove action
        type: 'POST',
        data: {
            id: medicineId,
            _token: $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
        },
        success: function (response) {
            $('#medicineList').html(response.html);
        },
        error: function (xhr, status, error) {
            console.error('AJAX error: ', error);
            alert('An error occurred. Please try again.');
        }
    });
});



</script>
