<script>
    $(document).ready(function() {
        loadBrands();

        function loadBrands() {
           // console.log("enter into loadBrand");
            $.ajax({
                url:  '/brands',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === true && response.code === 200) {
                        const brands = response.data.data;
                        $('#brand-table-body').empty();
                        brands.forEach(function(brand) {
                            $('#brand-table-body').append(
                                '<tr>' +
                                '<td>' + brand.id + '</td>' +
                                '<td>' + brand.name + '</td>' +
                                '<td>' + brand.description + '</td>' +
                                '<td>' + (brand.status == 1 ? 'Active' : 'Inactive') + '</td>' +
                                '<td>' +
                                '<a href="#" class="editBrandButton btn btn-warning" data-id="' + brand.id + '">Edit</a>' +
                                ' ' +
                                '<a href="#" class="deleteBrandButton btn btn-danger" data-id="' + brand.id + '">Delete</a>' +
                                '</td>' +
                                '</tr>'
                            );
                        });

                        $('.editBrandButton').click(function(e) {
                            /**
                             if you want to validate the form data before submission or send it via AJAX, you would use preventDefault() to stop the form from submitting.
                             */
                            e.preventDefault();
                            const id = $(this).data('id');
                            $.ajax({
                                url: '/brands/' + id + '/edit ',
                                type: 'GET',
                                dataType: 'json',
                                success: function (response) {
                                    if (response.status === true) {
                                        $('#edit-id').val(response.data.id);
                                        $('#edit-name').val(response.data.name);
                                        $('#editBrandDescription').val(response.data.description);
                                        $('#edit-status').val(response.data.status);
                                        $('#editBrandModal').modal('show');
                                    } else {
                                        alert(response.message);
                                    }
                                }
                            });
                        });

                        $('.deleteBrandButton').click(function(e) {
                            /**
                             if you want to validate the form data before submission or send it via AJAX, you would use preventDefault() to stop the form from submitting.
                             */
                            e.preventDefault();
                            const id = $(this).data('id');
                            if (confirm('Are you sure you want to delete this brand?')) {
                                $.ajax({
                                    url: '/brands/'+id,
                                    type: 'DELETE',
                                    dataType: 'json',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        if (response.status === true) {
                                            loadBrands(); // Refresh the list
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
                    }else{
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('An error occurred while fetching brands.');
                }
            });
        } // The END loadBrands()




        $('#openBrandModalButton').on('click', function() {
            $('#addBrandModal').modal('show');
        });


        $('#addBrandForm').on('submit', function(event) {
            /**
             if you want to validate the form data before submission or send it via AJAX, you would use preventDefault() to stop the form from submitting.
             */
            event.preventDefault();
            /**
             FormData:       This is specifically used for forms that need to send files (such as images) along with other data. It handles file uploads and other form fields seamlessly. You should use FormData when you have file inputs or binary data in the form.
             serialize():    This method is used for serializing form data into a URL-encoded string. It is suitable for forms that only contain text inputs, checkboxes, radio buttons, etc., but not for forms with file inputs.
             */
            let data = $(this).serialize();

            console.log(data);


            $.ajax({
                url: "{{ route('brands.store') }}",
                method: 'POST',
                data: data,
                success: function(response) {
                   // console.log(response);

                    if (response.status === true) {
                        $('#addBrandModal').modal('hide');
                        loadBrands();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });

        $('#editBrandForm').on('submit', function(event) {
            /**
             if you want to validate the form data before submission or send it via AJAX, you would use preventDefault() to stop the form from submitting.
             */
            event.preventDefault();
            const id = $('#edit-id').val();
            $.ajax({
                url : '/brands/'+ id,
                method: 'PUT',
                /**
                 FormData:       This is specifically used for forms that need to send files (such as images) along with other data. It handles file uploads and other form fields seamlessly. You should use FormData when you have file inputs or binary data in the form.
                 serialize():    This method is used for serializing form data into a URL-encoded string. It is suitable for forms that only contain text inputs, checkboxes, radio buttons, etc., but not for forms with file inputs.
                 */
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === true) {
                        $('#editBrandModal').modal('hide');
                        loadBrands();
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
