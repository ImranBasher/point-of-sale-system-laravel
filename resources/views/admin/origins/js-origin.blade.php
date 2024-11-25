<script>
    $(document).ready(function () {
        // Open Add Origin Modal
        $('#openOriginModalButton').click(function () {
            // console.log("Clicked on openOriginModalButton.");
            resetForm(); // Reset form fields
            $('#originModalLabel').text('Add Origin'); // Change modal title
            $('#originForm').attr('action', '{{ route("origins.store") }}'); // Set form action for adding
            $('#originForm').find('input[name="_method"]').remove(); // Remove any method field
            $('#saveButton').text('Add Origin'); // Change button text
            $('#originModal').modal('show'); // Show modal
        });

        // Open Edit Origin Modal and Set Selected Origin
        $(document).on('click', '.editOriginButton', function () {
            // console.log("Clicked on editOriginButton.");
            var originId = $(this).data('id'); // Get origin ID from button
            $('#originModalLabel').text('Edit Origin'); // Change modal title
            $('#originForm').attr('action', '/origins/' + originId); // Set form action for editing
            $('#originForm').append('<input type="hidden" name="_method" value="PUT">'); // Add PUT method for update
            $('#saveButton').text('Update Origin'); // Change button text

            // Fetch and populate the origin data
            $.ajax({
                url: '/origins/' + originId + '/edit',
                method: 'GET',
                success: function (data) {
                    // console.log('Fetched origin data:', data);
                    if (data.status === true && data.code === 200) {
                        // Populate form fields with the fetched data
                        $('#originId').val(data.data.id);
                        $('#origin_name').val(data.data.origin_name);
                        $('#status').val(data.data.status);

                        $('#originModal').modal('show');
                    } else {
                        console.error('Failed to fetch origin data:', data.message);
                    }
                },
                error: function (xhr) {
                    console.log('Error fetching origin data:', xhr.responseText);
                }
            });
        });

        // Reset Form Fields
        function resetForm() {
            $('#originForm')[0].reset(); // Reset form
            $('#originForm').find('input[name="_method"]').remove(); // Remove any method field
        }

        // Load Origins
        function loadOrigins() {
            // console.log("Loading origins...");
            $.ajax({
                url: '/origins',
                method: 'GET',
                success: function (response) {
                    // console.log('Origins response:', response);
                    if (response.status === true && response.code === 200) {
                        const origins = response.data.data;
                        if (Array.isArray(origins)) {
                            // console.log("After make json to Array : " + origins);
                            $('#origin-table-body').empty();

                            origins.forEach(origin => {
                                $('#origin-table-body').append(`
                                    <tr>
                                        <td>${origin.id}</td>
                                        <td>${origin.origin_name}</td>
                                        <td>${origin.status === '1' ? 'Active' : 'Inactive'}</td>
                                        <td>
                                            <a href="#" class="editOriginButton btn btn-warning" data-id="${origin.id}">Edit</a>
                                            <a href="#" class="deleteOriginButton btn btn-danger" data-id="${origin.id}">Delete</a>
                                        </td>
                                    </tr>
                                `);
                            });

                            // Attach delete event handler
                            attachDeleteHandler();
                        } else {
                            // console.error('Origins data is not an array:', origins);
                            $('#origin-table-body').append('<tr><td colspan="4">No origins available</td></tr>');
                        }
                    } else {
                        alert('Failed to load origins: ' + response.message);
                    }
                },
                error: function (xhr) {
                    alert('An error occurred while fetching origins.');
                }
            });
        }

        // Attach Delete Handler
        function attachDeleteHandler() {
            $('.deleteOriginButton').click(function (e) {
                e.preventDefault();
                const deleteId = $(this).data('id');
                if (confirm('Are you sure you want to delete this origin?')) {
                    $.ajax({
                        url: '/origins/' + deleteId,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.status === true) {
                                loadOrigins(); // Refresh the list
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            alert('An error occurred: ' + error);
                        }
                    });
                }
            });
        }

        // Initial load of origins
        loadOrigins();

        // Add and Edit origin
        $('#originForm').on('submit', function (e) {
            e.preventDefault();
            const originId = $('#originId').val();

            let formData = new FormData(this);

            // Append CSRF token
            formData.append("_token", "{{ csrf_token() }}");

            if (originId) {
                $.ajax({
                    url: '/origins/' + originId,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status === true) {
                            resetForm();
                            $('#originModal').modal('hide');
                            loadOrigins();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (response) {
                        alert('An error occurred: ' + response.message);
                    }
                });
            } else {
                $.ajax({
                    url: "{{ route('origins.store') }}",
                    method: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === true) {
                            resetForm();
                            $('#originModal').modal('hide');
                            loadOrigins();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("Server Error Response", xhr);
                    }
                });
            }
        });
    });
</script>
