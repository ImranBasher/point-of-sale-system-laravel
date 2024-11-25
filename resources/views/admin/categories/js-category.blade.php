<script>
    $(document).ready(function () {
        // Open Add Category Modal and Load Categories
        $('#openCategoryModalButton').click(function () {
            // console.log("Clicked on openCategoryModalButton.");
            resetForm(); // Reset form fields
            $('#categoryModalLabel').text('Add Category'); // Change modal title
            $('#categoryForm').attr('action', '{{ route("categories.store") }}'); // Set form action for adding
            $('#categoryForm').find('input[name="_method"]').remove(); // Remove any method field
            $('#saveButton').text('Add Category'); // Change button text
            loadCategoriesDropdown(); // Load categories into dropdown
            $('#categoryModal').modal('show'); // Show modal
        });

        // Open Edit Category Modal, Load Categories, and Set Selected Category
        $(document).on('click', '.editCategoryButton', function () {
            // console.log("Clicked on editCategoryButton.");
            var categoryId = $(this).data('id'); // Get category ID from button
            $('#categoryModalLabel').text('Edit Category'); // Change modal title
            $('#categoryForm').attr('action', '/categories/' + categoryId); // Set form action for editing
            $('#categoryForm').append('<input type="hidden" name="_method" value="PUT">'); // Add PUT method for update
            $('#saveButton').text('Update Category'); // Change button text

            // Load categories into dropdown and set the selected category
            loadCategoriesDropdown(function() {
                // Fetch and populate the category data
                $.ajax({
                    url: '/categories/' + categoryId + '/edit',
                    method: 'GET',
                    success: function (data) {
                        // console.log('Fetched category data:', data);
                        if (data.status === true && data.code === 200) {
                            // Populate form fields with the fetched data
                            $('#categoryId').val(data.data.id);
                            $('#title').val(data.data.title);

                            $('#position_no').val(data.data.position_no);
                            $('#status').val(data.data.status);
                            $('#thumbnail').attr('data-old-thumbnail', data.data.thumbnail);

                            // Set the selected category in the dropdown
                            $('#parentCategory').val(data.data.parent_category_id);

                            $('#categoryModal').modal('show');
                        } else {
                            console.error('Failed to fetch category data:', data.message);
                        }
                    },
                    error: function (xhr) {
                        console.log('Error fetching category data:', xhr.responseText);
                    }
                });
            });
        });


        function loadCategoriesDropdown(callback) {
            // console.log("Loading categories for dropdown...");
            $.ajax({
                url: '/categories',
                method: 'GET',
                success: function (response) {
                    // console.log('Categories for dropdown:', response);
                    if (response.status === true && response.code === 200) {
                        const categories = response.data.data;
                        const dropdown = $('#parent_category');
                        dropdown.empty();

                        // Append a default option
                        dropdown.append('<option value="">Select Category</option>');

                        if (Array.isArray(categories)) {
                            categories.forEach(category => {

                                dropdown.append(`<option value="${category.id}" >${category.title}</option>`);
                            });
                        } else {
                            console.error('Categories data is not an array:', categories);
                        }

                        if (typeof callback === 'function') {
                            callback();
                        }
                    } else {
                        alert('Failed to load categories: ' + response.message);
                    }
                },
                error: function (xhr) {
                    alert('An error occurred while fetching categories for dropdown.');
                }
            });
        }

        // Reset Form Fields
        function resetForm() {
            $('#categoryForm')[0].reset(); // Reset form
            $('#categoryForm').find('input[name="_method"]').remove(); // Remove any method field
            $('#categoryForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation classes
            $('#categoryForm').find('.invalid-feedback').remove(); // Remove validation messages
        }
        // Load Categories
        function loadCategories() {
            // console.log("Loading categories...");
            $.ajax({
                url: '/categories',
                method: 'GET',
                success: function (response) {
                    // console.log('Categories responsessssssszzzzzzzzzzzzzzzzzzz:', response);
                    if (response.status === true && response.code === 200) {
                        const categories = response.data.data;
                        if (Array.isArray(categories)) {
                            // console.log("After make json to Array : "+ categories);
                            $('#category-table-body').empty();
                            // Ensure the base URL is correctly fetched using Blade syntax
                            // const baseURL = 'http://127.0.0.1:8000/';
                            var baseURL = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');

                          //  console.log('Base URL:', baseURL); // Debugging: Check the base URL in console

                            // Assuming categories is a valid array with thumbnail data
                            categories.forEach(category => {
                                const imageUrl = `${baseURL}categories/${category.thumbnail}`;
                                // console.log('Image URL:', imageUrl);
                                var thumbnailHtml = category.thumbnail
                                    ? `<img src="${baseURL}/storage/categories/${category.thumbnail}" alt="Thumbnail" style="width: 150px; height: 100px; margin-right: 5px;">`
                                    : '-';
                                // var thumbnailHtmll = category.thumbnail
                                //     ? `<img  src="${imageUrl}" alt="Thumbnail" style="width: 50px; height: 50px; margin-right: 5px;">`
                                //     : '-';

                                $('#category-table-body').append(`
                                    <tr>
                                        <td>${category.id}</td>
                                        <td>${category.title}</td>
                                        <td>${category.parent_category_id ? category.parent_category.title : '-'}</td>
                                        <td>${category.position_no || '-'}</td>
                                        <td>${thumbnailHtml}</td>
                                        <td>${category.status ? 'Active' : 'Inactive'}</td>
                                        <td>${category.created_by_id || '-'}</td>
                                        <td>${category.updated_by_id || '-'}</td>
                                        <td>
                                            <a href="#" class="editCategoryButton btn btn-warning" data-id="${category.id}">Edit</a>
                                            <a href="#" class="deleteCategoryButton btn btn-danger" data-id="${category.id}">Delete</a>
                                        </td>
                                    </tr>
                                `);
                            });

                            // Attach delete event handler
                            attachDeleteHandler();
                        } else {
                            console.error('Categories data is not an array:', categories);
                            $('#category-table-body').append('<tr><td colspan="8">No categories available</td></tr>');
                        }
                    } else {
                        alert('Failed to load categories: ' + response.message);
                    }
                },
                error: function (xhr) {
                    alert('An error occurred while fetching categories.');
                }
            });
        }

        // Attach Delete Handler
        function attachDeleteHandler() {
            $('.deleteCategoryButton').click(function (e) {
                e.preventDefault();
                const deleteId = $(this).data('id');
                if (confirm('Are you sure you want to delete this category?')) {
                    $.ajax({
                        url: '/categories/' + deleteId,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.status === true) {
                                loadCategories(); // Refresh the list
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

        // Initial load of categories
        loadCategories();

        // Add and Edit category
        $('#categoryForm').on('submit', function (e) {
            e.preventDefault();
            const categoryId = $('#categoryId').val();

            let formData = new FormData(this);

            // Append CSRF token
            formData.append("_token", "{{ csrf_token() }}");

            if (categoryId) {
                $.ajax({
                    url: '/categories/' + categoryId,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status === true) {
                            $('#categoryModal').modal('hide');
                            loadCategories();
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
                    url: "{{ route('categories.store') }}",
                    method: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === true) {
                            resetForm();
                            $('#categoryModal').modal('hide');
                            loadCategories();
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
