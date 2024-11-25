<script>
    $(document).ready(function () {
        // Open Add Subcategory Modal
        $('#openSubcategoryModalButton').click(function () {
            // console.log("Clicked on openSubcategoryModalButton.");
            resetForm(); // Reset form fields
            $('#subcategoryModalLabel').text('Add Subcategory'); // Change modal title
            $('#subcategoryForm').attr('action', '{{ route("subcategories.store") }}'); // Set form action for adding
            $('#subcategoryForm').find('input[name="_method"]').remove(); // Remove any method field
            $('#saveButton').text('Add Subcategory'); // Change button text
            $('#subcategoryModal').modal('show'); // Show modal
        });

        // Open Edit Subcategory Modal
        $(document).on('click', '.editSubcategoryButton', function () {
            // console.log("Clicked on editSubcategoryButton.");
            var subcategoryId = $(this).data('id'); // Get subcategory ID from button
            $('#subcategoryModalLabel').text('Edit Subcategory'); // Change modal title
            $('#subcategoryForm').attr('action', '/subcategories/' + subcategoryId); // Set form action for editing
            $('#subcategoryForm').append('<input type="hidden" name="_method" value="PUT">'); // Add PUT method for update
            $('#saveButton').text('Update Subcategory'); // Change button text

            // Fetch and populate the subcategory data
            $.ajax({
                url: '/subcategories/' + subcategoryId + '/edit',
                method: 'GET',
                success: function (data) {
                    // console.log('Fetched subcategory data:', data);
                    if (data.status === true && data.code === 200) {
                        // Populate form fields with the fetched data
                        $('#subcategoryId').val(data.data.id);
                        $('#title').val(data.data.title);
                        $('#category').val(data.data.category_id).trigger('change');
                        $('#position_no').val(data.data.position_no);
                        $('#status').val(data.data.status);

                        // Set thumbnail if available
                        if (data.data.thumbnail) {
                            $('#thumbnail').attr('data-old-thumbnail', data.data.thumbnail);
                        }

                        $('#subcategoryModal').modal('show');
                    } else {
                        console.error('Failed to fetch subcategory data:', data.message);
                    }
                },
                error: function (xhr) {
                    console.log('Error fetching subcategory data:', xhr.responseText);
                }
            });
        });

        // Reset Form Fields
        function resetForm() {
            $('#subcategoryForm')[0].reset(); // Reset form
            $('#subcategoryForm').find('input[name="_method"]').remove(); // Remove any method field
            $('#subcategoryForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation classes
            $('#subcategoryForm').find('.invalid-feedback').remove(); // Remove validation messages
        }

        // Load Categories
        function loadCategories() {
            $.ajax({
                url: '/categories',
                method: 'GET',
                success: function (response) {
                  //  console.log('Categories response:', response);
                    if (response.status === true && response.code === 200) {
                        const categories = response.data.data;
                        if (Array.isArray(categories)) {
                            $('#category').empty().append(categories.map(category => `<option value="${category.id}">${category.name}</option>`));
                        } else {
                            // console.error('Categories data is not an array:', categories);
                            $('#category').append('<option value="">No categories available</option>');
                        }
                    } else {
                        console.error('Failed to load categories:', response.message);
                    }
                },
                error: function (xhr) {
                    console.error('Error loading categories:', xhr.responseText);
                }
            });
        }

        // Load categories on page load
        loadCategories();

        // Load subcategories
        function loadSubcategories() {



            // console.log("===================-----------------------------");
            $.ajax({
                url: '/subcategories',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    // console.log('Subcategories response:', response);
                    if (response.status === true && response.code === 200) {
                        const subcategories = response.data.data;

                        if (Array.isArray(subcategories)) {
                            $('#subcategory-table-body').empty();

                            subcategories.forEach(subcategory => {
                                const thumbnailHtml = subcategory.thumbnail
                                    ? `<img src="/subcategory/${subcategory.thumbnail}" alt="Thumbnail" style="width: 50px; height: 50px; margin-right: 5px;">`
                                    : '-';

                                $('#subcategory-table-body').append(`
                        <tr>
                            <td>${subcategory.id}</td>
                            <td>${subcategory.title}</td>
                            <td>${subcategory.category ? subcategory.category.name : '-'}</td>
                            <td>${subcategory.position_no || '-'}</td>
                            <td>${thumbnailHtml}</td>
                            <td>${subcategory.status ? 'Active' : 'Inactive'}</td>
                            <td>${subcategory.created_by_id || '-'}</td>
                            <td>${subcategory.updated_by_id || '-'}</td>
                            <td>
                                <a href="#" class="editSubcategoryButton btn btn-warning" data-id="${subcategory.id}">Edit</a>
                                <a href="#" class="deleteSubcategoryButton btn btn-danger" data-id="${subcategory.id}">Delete</a>
                            </td>
                        </tr>
                    `);
                            });
                        } else {
                            console.error('Subcategories data is not an array:', subcategories);
                            $('#subcategory-table-body').append('<tr><td colspan="8">No subcategories available</td></tr>');
                        }

                        $('.deleteSubcategoryButton').click(function (e) {
                            e.preventDefault();
                            const deleteId = $(this).data('id');
                            if (confirm('Are you sure you want to delete this subcategory?')) {
                                $.ajax({
                                    url: '/subcategories/' + deleteId,
                                    type: 'DELETE',
                                    dataType: 'json',
                                    data: {
                                        _method: 'DELETE',
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function (response) {
                                        if (response.status === true) {
                                            loadSubcategories(); // Refresh the list
                                        } else {
                                            alert(response.message);
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        // alert('An error occurred: ' + error);
                                    }
                                });
                            }
                        });

                    } else {
                        alert('Failed to load subcategories: ' + response.message);
                    }
                },
                error: function (xhr) {
                    alert('An error occurred while fetching subcategories.');
                }
            });
        }

        // Initial load of subcategories
        loadSubcategories();

        // Add and Edit subcategory
        $('#subcategoryForm').on('submit', function (e) {
            e.preventDefault();
            const subcategoryId = $('#subcategoryId').val();

            let formData = new FormData(this);

            // Append CSRF token
            formData.append("_token", "{{ csrf_token() }}");

            if (subcategoryId) {
                $.ajax({
                    url: '/subcategories/' + subcategoryId,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status === true) {
                            $('#subcategoryModal').modal('hide');
                            loadSubcategories();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (response) {
                        // alert('An error occurred: ' + response.message);
                    }
                });
            } else {
                $.ajax({
                    url: "{{ route('subcategories.store') }}",
                    method: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === true) {
                            resetForm();
                            $('#subcategoryModal').modal('hide');
                            loadSubcategories();
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
