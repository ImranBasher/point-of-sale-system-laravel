<script>
    $(document).ready(function () {
        // Open Add Unit Modal
        $(document).on('click', '#openUnitModalButton', function ()  {
            console.log("Clicked on openUnitModalButton.");
            resetForm();
            $('#unitModalLabel').text('Add Unit');
            $('#unitForm').attr('action', '{{ route("units.store") }}');
            $('#unitForm').find('input[name="_method"]').remove();
            $('#saveButton').text('Add Unit');
            $('#unitModal').modal('show');
        });

        // Open Edit Unit Modal and Set Selected Unit
        $(document).on('click', '.editUnitButton', function (e) {
            e.preventDefault();
            console.log("Clicked on editUnitButton.");

            var unitId = $(this).data('id');

            $('#unitModalLabel').text('Edit Unit');
            $('#unitForm').attr('action', '/units/' + unitId);
            $('#unitForm').append('<input type="hidden" name="_method" value="PUT">');
            $('#saveButton').text('Update Unit');


            // you also have to use "this" keyword for class or id name otherwise it is targeted 1st class name only
             let route = $(this).attr('href'); // you must set prevent default otherwise data will go to the destination (i mean route)
           // let route1 = $('.editUnitButton').href;   // we cannot use it because it is OLD js format and omitted that is work in jQuery
           // const editId = $('.editUnitButton').data('id'); // if you use prevent default to protect the edit submission/go to that route link in controller then omit this way collect the id, because id already you sat on href (<a href="/units/${unit.id}/edit" class="editUnitButton btn btn-warning">Edit</a>).
           // let route2 = '/units/' + editId + '/edit/',   //
            $.ajax({
                url: route,
                method: 'GET',
                success: function (data) {
                    console.log('Fetched unit data:', data);
                    if (data.status === true && data.code === 200) {
                        // Populate form fields with the fetched data
                        $('#unitId').val(data.data.id);
                        $('#name').val(data.data.name);
                        $('#status').val(data.data.status);

                        $('#unitModal').modal('show');
                    } else {
                        console.error('Failed to fetch unit data:', data.message);
                    }
                },
                error: function (xhr) {
                    console.log('Error fetching unit data:', xhr.responseText);
                }
            });
        });

        // Reset Form Fields
        function resetForm() {
            $('#unitForm')[0].reset(); // Reset form
            $('#unitForm').find('input[name="_method"]').remove(); // Remove any method field
        }

        // Load Units
        function loadUnits() {
           // console.log("Loading units...");
            $.ajax({
                url: '/units',
                method: 'GET',
                success: function (response) {
                  //  console.log('Units response:', response);
                    if (response.status === true && response.code === 200) {
                        const units = response.data.data;
                        if (Array.isArray(units)) {
                         //   console.log("After making JSON to Array : " + units);
                            $('#unit-table-body').empty();

                            units.forEach(unit => {
                                $('#unit-table-body').append(`
                                    <tr>
                                        <td>${unit.id}</td>
                                        <td>${unit.name}</td>
                                        <td>${unit.status === '1' ? 'Active' : 'Inactive'}</td>
                                        <td>
                                        {{--<a href="{{route('units.edit')}},${unit.id}">Edit</a>          This way we cannot set route with js valu/variable because we set route in blade file and blade file cannot support js inseted of <script></script> --}}
                                           {{-- <a href="#" class="editUnitButton btn btn-warning" data-id="${unit.id}">Edit</a>--}}
                                           {{-- <a href="/units/${unit.id}/edit" class="editUnitButton btn btn-warning">Edit</a>   --}}{{-- This is also not a good practice to set route link for edit because when you click it definitly will go to ajax but also goto the controller due to we cannot set preventDefault --}}
                                           {{-- <a href="/units/${unit.id}" class="deleteUnitButton btn btn-danger" >Delete</a>--}}
                                       {{--
                                       <a href="#" class="editUnitButton btn btn-warning" data-id="${unit.id}">Edit</a>
                                        // <a href="#" class="deleteUnitButton btn btn-danger" data-id="${unit.id}">Delete</a>
                                       --}}
                                            <a href="/units/${unit.id}/edit" class="editUnitButton btn btn-warning" data-id="${unit.id}">Edit</a>  {{-- i have to set this(data-id="${unit.id}" because i set action for <form> in edit where i need the id for update but i can also omit it because in the edited value retrive time i can also find the id which i can keep in a hidden input) --}}
                                            <a href="/units/${unit.id}/" class="deleteUnitButton btn btn-danger" data-id="${unit.id}">Delete</a>

                                        </td>
                                    </tr>
                                `);
                            });
                            // Attach delete event handler
                            attachDeleteHandler();
                        } else {
                            console.error('Units data is not an array:', units);
                            $('#unit-table-body').append('<tr><td colspan="4">No units available</td></tr>');
                        }
                    } else {
                        alert('Failed to load units: ' + response.message);
                    }
                },
                error: function (xhr) {
                    alert('An error occurred while fetching units.');
                }
            });
        }

        // Attach Delete Handler
        function attachDeleteHandler() {

            $('.deleteUnitButton').click(function (e) {
                e.preventDefault();
                const deleteId = $(this).data('id');

                let route = $(this).attr('href');
                console.log(route);
                if (confirm('Are you sure you want to delete this unit?')) {
                    $.ajax({
                        url: route,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.status === true) {
                                loadUnits(); // Refresh the list
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

        // Initial load of units
        loadUnits();

        // Add and Edit unit
        $('#unitForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            formData.append("_token", "{{ csrf_token() }}");
         //   $('#unitForm').attr('action', '/units/' + unitId);

            const unitId = $('#unitId').val();
            let route  = $(this).attr('action')

            if (unitId) {
                $.ajax({
                    // url: '/units/' + unitId,
                    url: route,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status === true) {
                            resetForm();
                            $('#unitModal').modal('hide');
                            loadUnits();
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
                    {{--url: "{{ route('units.store') }}",--}}
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
                            $('#unitModal').modal('hide');
                            loadUnits();
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
