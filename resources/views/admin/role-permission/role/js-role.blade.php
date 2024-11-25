<script>
    $(document).ready(function () {

        $('#roleModal').modal('hide');

        function resetForm() {
            var form = $('#roleForm');
            form[0].reset();
            form.find('input[name="_method"]').remove();

        }

        $(document).on('click','#openRoleModalButton', function () {
          //  console.log("Clicked on openRoleModalButton.");
            resetForm();
            $('#roleModalLabel').text('Add Role');
            $('#roleForm').attr('action', '{{ route("roles.store") }}');
            $('#roleForm').find('input[name="_method"]').remove();
            $('#saveButton').text('Add Role');
            $('#roleModal').modal('show');
        });


        $(document).on('click', '.editRoleButton', function (e) {
          //  console.log("edit button clicked");
            e.preventDefault();
            var roleId = $(this).data('id');
            $('#roleModalLabel').text('Edit Role');
            $('#roleForm').attr('action', '/roles/' + roleId);
            $('#roleForm').append('<input type="hidden" name="_method" value="PUT">');
            $('#saveButton').text('Update Role');

            let route = $(this).attr('href');

            // let route = $(this).attr('action');

            console.log('Role edit Route' + route);

            $.ajax({
                url: route,
                method: 'GET',
                success: function (response) {
                   // console.log(response);
                    if (response.status === true && response.code === 200) {

                        var data = response.data.role;
                       // console.log(data);
                        $('#roleId').val(data.id);
                        $('#name').val(data.name);
                        $('#roleModal').modal('show');
                    } else {
                        console.error('Failed to fetch role data:', response.message);
                    }
                },
                error: function (xhr) {
                    console.log('Error fetching product data:', xhr.responseText); // Handle error
                }
            });
        });

        $(document).on('click', '.add-edit-Role-Permission-Button', function (e) {
              console.log("add-edit-Role-Permission-Button clicked");
            e.preventDefault();
           // var roleId = $(this).data('id');
            window.location.href = $(this).attr('href');
        });





        let currentPage = 1;
        let isLoading = false;

        function loadRoles() {
      //  console.log("LOad call");
            let route = "{{route('roles.index')}}";

            $.ajax({
                // url: '/products',
                url: route,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                   // console.log(response);
                    if (response.status === true && response.code === 200) {
                        const roles = response.data.roles.data;

                      //  console.log("now roles : " + roles);

                        $('#role-table-body').empty();
                        let i = 1;
                        if (Array.isArray(roles)) {

                            roles.forEach(role => {

                                $('#role-table-body').append(`
                                                                <tr>
                                                                    <td>${i++}</td>

                                                                    <td>${role.name}</td>

                                                                    <td>
{{--<a href="{{route('roles.give-permission', $role->id)}}" class="btn btn-warning">Add / Edit Role Permission</a>--}}

                                                                        <a href="/roles/${role.id}/add-permission" class="add-edit-Role-Permission-Button btn btn-warning"  data-id="${role.id}">Add / Edit Role Permission </a>
                                                                        <a href="/roles/${role.id}/edit" class="editRoleButton btn btn-warning" data-id="${role.id}">Edit</a>
                                                                        <a href="/roles/${role.id}" class="deleteRoleButton btn btn-danger" data-id="${role.id}">Delete</a>
                                                                    </td>
                                                                </tr>
                                    `);
                            });
                        } else {
                            $('#role-table-body').append('<tr><td colspan="12">No roles available</td></tr>');
                        }


                        $('.deleteRoleButton').click(function (e) {
                            e.preventDefault();

                            let route = $(this).attr('href');
                            const deleteId = $(this).data('id');
                            if (confirm('Are you sure you want to delete this role?')) {
                                $.ajax({
                                    url:route,
                                    type: 'DELETE',
                                    dataType: 'json',
                                    data: {
                                        _method: 'DELETE',
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function (response) {
                                       // console.log(response);
                                        if (response.status === true) {
                                            loadRoles(); // Refresh the list
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
        loadRoles();


        // add and EDIT role
        $('#roleForm').on('submit', function(e){

            e.preventDefault();

            const roleId = $('#roleId').val();

         //   console.log("roleId : "+roleId);

            let formData = new FormData(this);

            let route = $(this).attr('action');

            formData.append("_token","{{ csrf_token() }}");

         //   console.log("formdata :" + formData);

            if(roleId ){
                console.log("formdata :" + formData);
                $.ajax({
                    // url: '/roles/'+ roleId,
                    url: route,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,  //
                    success:function(response){
                        if(response.status === true){
                            $('#roleModal').modal('hide');
                            loadRoles();
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
                    {{--url: "{{ route('roles.store') }}",--}}
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
                            $('#roleModal').modal('hide');
                            loadRoles();
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

