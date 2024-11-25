<script>
    $(document).ready(function () {

        $('#permissionModal').modal('hide');

        function resetForm() {
            var form = $('#permissionForm');
            form[0].reset();
            form.find('input[name="_method"]').remove();

        }

        $(document).on('click','#openPermissionModalButton', function () {
            console.log("Clicked on openRoleModalButton.");
            resetForm();
            $('#permissionModalLabel').text('Add Permission');
            $('#permissionForm').attr('action', '{{ route("permissions.store") }}');
            $('#permissionForm').find('input[name="_method"]').remove();
            $('#saveButton').text('Add Permission');
            $('#permissionModal').modal('show');
        });


        $(document).on('click', '.editPermissionButton', function (e) {
            console.log("edit button clicked");
            e.preventDefault();
            var permissionId = $(this).data('id');

            console.log(permissionId);

            $('#permissionModalLabel').text('Edit Permission');
            $('#permissionForm').attr('action', '/permissions/' + permissionId);
            $('#permissionForm').append('<input type="hidden" name="_method" value="PUT">');
            $('#saveButton').text('Update permission');

            let route = $(this).attr('href');

            // let route = $(this).attr('action');

            console.log('Permission edit Route' + route);

            $.ajax({
                url: route,
                method: 'GET',
                success: function (response) {
                    console.log(response);
                    if (response.status === true && response.code === 200) {

                        var data = response.data.permission;
                        console.log(data);
                        $('#permissionId').val(data.id);
                        $('#name').val(data.name);
                        $('#permissionModal').modal('show');
                    } else {
                        console.error('Failed to fetch permission data:', response.message);
                    }
                },
                error: function (xhr) {
                    console.log('Error fetching permission data:', xhr.responseText); // Handle error
                }
            });
        });


        function loadPermissions() {
      //  console.log("LOad call");
            let route = "{{route('permissions.index')}}";

            $.ajax({
                // url: '/permissions',
                url: route,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.status === true && response.code === 200) {
                        const permissions = response.data.permissions.data;

                        console.log("now permissions : " + permissions);

                        $('#permission-table-body').empty();
                        let i = 1;
                        if (Array.isArray(permissions)) {

                            permissions.forEach(permission => {

                                $('#permission-table-body').append(`
                                                                <tr>
                                                                    <td>${i++}</td>

                                                                    <td>${permission.name}</td>

                                                                    <td>
                                                                        <a href="/permissions/${permission.id}/edit" class="editPermissionButton btn btn-warning" data-id="${permission.id}">Edit</a>
                                                                        <a href="/permissions/${permission.id}" class="deletePermissionButton btn btn-danger" data-id="${permission.id}">Delete</a>
                                                                    </td>
                                                                </tr>
                                    `);
                            });
                        } else {
                            $('#permission-table-body').append('<tr><td colspan="12">No permissions available</td></tr>');
                        }


                        $('.deletePermissionButton').click(function (e) {
                            e.preventDefault();

                            let route = $(this).attr('href');
                            const deleteId = $(this).data('id');
                            if (confirm('Are you sure you want to delete this permission?')) {
                                $.ajax({
                                    url:route,
                                    type: 'DELETE',
                                    dataType: 'json',
                                    data: {
                                        _method: 'DELETE',
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function (response) {
                                        console.log(response);
                                        if (response.status === true) {
                                            loadPermissions(); // Refresh the list
                                        } else {
                                            //  alert(response.message);
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        // alert('An error occurred: ' + error);
                                    }
                                });
                            }
                        });

                    } else {
                        // alert('Failed to load products: ' + response.message);
                    }
                },
                error: function (xhr) {
                    //   alert('An error occurred while fetching products.');
                }
            });
        }

        // Initial load of products
        loadPermissions();


        // add and EDIT role
        $('#permissionForm').on('submit', function(e){

            e.preventDefault();

            const permissionId = $('#permissionId').val();

            console.log("permissionId : "+permissionId);

            let formData = new FormData(this);

            let route = $(this).attr('action');

            formData.append("_token","{{ csrf_token() }}");

            console.log("formdata :" + formData);

            if(permissionId ){
                console.log("formdata :" + formData);
                $.ajax({
                    // url: '/permissions/'+ permissionId,
                    url: route,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,  //
                    success:function(response){
                        if(response.status === true){
                            $('#permissionModal').modal('hide');
                            loadPermissions();
                        }else{
                            alert(response.message);
                        }
                    },
                    error: function(response){
                        alert('An error occurred: ' + response.message);
                    }
                });
            }else {
                $.ajax({
                    {{--url: "{{ route('permissions.store') }}",--}}
                    url: route,
                    method: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === true) {
                            resetForm();
                            $('#permissionModal').modal('hide');
                            loadPermissions();
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

