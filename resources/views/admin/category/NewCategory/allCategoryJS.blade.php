<script>
    $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

        loadCategories();
        // Function to load categories
        function loadCategories(page) {

           // console.log("enter into loadCategories");
            $.ajax({
                url:  '/categories?page=' + page,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === true && response.code === 200) {
                        const categories = response.data.data; // Access the categories array
                        $('#table-body').empty(); // Clear existing rows
                        categories.forEach(function(category) {
                            $('#table-body').append(
                                '<tr>' +
                                '<td>' + category.id + '</td>' +
                                '<td>' + category.name + '</td>' +
                                '<td>' + (category.status == 1 ? 'Active' : 'Inactive') + '</td>' +
                                '<td>' +
                                '<a href="#" class="editButton btn btn-warning" data-id="' + category.id + '">Edit</a>' +
                                ' ' +
                                '<a href="#" class="deleteButton btn btn-danger" data-id="' + category.id + '">Delete</a>' +
                                '</td>' +
                                '</tr>'
                            );
                        });

                        // Render pagination links
                        let paginationLinks = response.data.links.map(link => {
                            if (link.url) {
                                return `<a href="${link.url}" class="${link.active ? 'active' : ''}">${link.label}</a>`;
                            }
                            return `<span>${link.label}</span>`;
                        }).join(' ');
                        $('#pagination-controls').html(paginationLinks);


                        // Bind click events for edit and delete buttons
                        $('.editButton').click(function(e) {
                            /**
                             if you want to validate the form data before submission or send it via AJAX, you would use preventDefault() to stop the form from submitting.
                             */
                            e.preventDefault();
                            const id = $(this).data('id');
                            $.ajax({
                                url: '/categories/' + id + '/edit',
                                type: 'GET',
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status === true) {
                                        $('#edit-id').val(response.data.id);
                                        $('#edit-name').val(response.data.name);
                                        $('#edit-status').val(response.data.status);
                                        $('#editCategoryModal').modal('show');
                                    } else {
                                        alert(response.message);
                                    }
                                }
                            });
                        });

                        $('.deleteButton').click(function(e) {
                            /**
                             if you want to validate the form data before submission or send it via AJAX, you would use preventDefault() to stop the form from submitting.
                             */
                            e.preventDefault();
                            const id = $(this).data('id');
                            if (confirm('Are you sure you want to delete this category?')) {
                                $.ajax({
                                    url: '/categories/' + id,
                                    type: 'DELETE',
                                    dataType: 'json',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        if (response.status === true) {
                                            loadCategories(); // Refresh the list
                                        } else {
                                            alert(response.message);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        alert('An error occurred: ' + error);
                                    }
                                });
                            }
                        });
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('An error occurred while fetching categories.');
                }
            });
        }

        // Event delegation for pagination links
        $(document).on('click', '.pagination a', function(e) {
            /**
             if you want to validate the form data before submission or send it via AJAX, you would use preventDefault() to stop the form from submitting.
             */
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            loadCategories(page);
        });

        // Initial load of categories


        $('#openCategoryModalButton').on('click', function() {
            $('#addCategoryModal').modal('show');
        });

        // Handle form submission for adding a category
        $('#addCategoryForm').on('submit', function(event) {
            /**
             if you want to validate the form data before submission or send it via AJAX, you would use preventDefault() to stop the form from submitting.
             */
            event.preventDefault();
            $.ajax({
                url: "{{ route('categories.store') }}",
                method: 'POST',
                /**
                 FormData:       This is specifically used for forms that need to send files (such as images) along with other data. It handles file uploads and other form fields seamlessly. You should use FormData when you have file inputs or binary data in the form.
                 serialize():    This method is used for serializing form data into a URL-encoded string. It is suitable for forms that only contain text inputs, checkboxes, radio buttons, etc., but not for forms with file inputs.
                 */
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === true) {
                        $('#addCategoryModal').modal('hide');
                        loadCategories();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });

        // Handle form submission for editing a category
        $('#editCategoryForm').on('submit', function(event) {
            event.preventDefault();
            const id = $('#edit-id').val();
            $.ajax({
                url: '/categories/' + id,
                method: 'PUT',
                /**
                    FormData:       This is specifically used for forms that need to send files (such as images) along with other data. It handles file uploads and other form fields seamlessly. You should use FormData when you have file inputs or binary data in the form.
                    serialize():    This method is used for serializing form data into a URL-encoded string. It is suitable for forms that only contain text inputs, checkboxes, radio buttons, etc., but not for forms with file inputs.
                 */
                data: $(this).serialize(),

                success: function(response) {
                    if (response.status === true) {
                        $('#editCategoryModal').modal('hide');
                        loadCategories();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });
    });

</script>
