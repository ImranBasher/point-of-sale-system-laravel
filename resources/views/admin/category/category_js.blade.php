{{--<script>--}}

{{--    $(document).ready(function() {--}}

{{--        $('.addButton').on('click', function(e) {--}}
{{--            e.preventDefault();--}}
{{--            let entity = $(this).data('entity'); // Get the entity type (category, brand, etc.)--}}

{{--            $('#commonModalLabel').text('Add ' + entity.charAt(0).toUpperCase() + entity.slice(1));--}}
{{--            $('#commonForm').attr('action', '/' + entity + '/store');--}}
{{--            $('#name').val('');--}}
{{--            $('#status').val(1); // Default to Active--}}

{{--            // Clear dynamic fields--}}
{{--            $('#dynamicFields').empty();--}}

{{--            // Add entity-specific fields--}}
{{--            if (entity === 'product') {--}}
{{--                $('#dynamicFields').append(`--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="price" class="form-label">Price</label>--}}
{{--                            <input type="text" class="form-control" id="price" name="price">--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="min_quantity" class="form-label">Minimum Quantity</label>--}}
{{--                            <input type="number" class="form-control" id="min_quantity" name="min_quantity">--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="max_quantity" class="form-label">Maximum Quantity</label>--}}
{{--                            <input type="number" class="form-control" id="max_quantity" name="max_quantity">--}}
{{--                        </div>--}}
{{--                    `);--}}
{{--            } else if (entity === 'brand') {--}}
{{--                $('#dynamicFields').append(`--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="description" class="form-label">Description</label>--}}
{{--                            <textarea class="form-control" id="description" name="description"></textarea>--}}
{{--                        </div>--}}
{{--                    `);--}}
{{--            }--}}
{{--            // Add more conditions for other entities as needed--}}

{{--            $('#commonModal').modal('show');--}}
{{--        });--}}

{{--        // Function to open the modal for editing an existing entity--}}
{{--        $('.editButton').on('click', function(e) {--}}
{{--            e.preventDefault();--}}
{{--            let entity = $(this).data('entity');--}}
{{--            let id = $(this).data('id');--}}

{{--            $('#commonModalLabel').text('Edit ' + entity.charAt(0).toUpperCase() + entity.slice(1));--}}
{{--            $('#commonForm').attr('action', '/' + entity + '/update/' + id);--}}

{{--            // Clear dynamic fields--}}
{{--            $('#dynamicFields').empty();--}}

{{--            // Fetch data from the server using AJAX--}}
{{--            $.ajax({--}}
{{--                url: '/' + entity + '/' + id + '/edit',--}}
{{--                method: 'GET',--}}
{{--                success: function(data) {--}}
{{--                    $('#name').val(data.name);--}}
{{--                    $('#status').val(data.status);--}}

{{--                    // Add entity-specific fields with pre-filled values--}}
{{--                    if (entity === 'product') {--}}
{{--                        $('#dynamicFields').append(`--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label for="price" class="form-label">Price</label>--}}
{{--                                    <input type="text" class="form-control" id="price" name="price" value="${data.price}">--}}
{{--                                </div>--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label for="min_quantity" class="form-label">Minimum Quantity</label>--}}
{{--                                    <input type="number" class="form-control" id="min_quantity" name="min_quantity" value="${data.min_quantity}">--}}
{{--                                </div>--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label for="max_quantity" class="form-label">Maximum Quantity</label>--}}
{{--                                    <input type="number" class="form-control" id="max_quantity" name="max_quantity" value="${data.max_quantity}">--}}
{{--                                </div>--}}
{{--                            `);--}}
{{--                    } else if (entity === 'brand') {--}}
{{--                        $('#dynamicFields').append(`--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label for="description" class="form-label">Description</label>--}}
{{--                                    <textarea class="form-control" id="description" name="description">${data.description}</textarea>--}}
{{--                                </div>--}}
{{--                            `);--}}
{{--                    }--}}
{{--                    // Add more conditions for other entities as needed--}}

{{--                    $('#commonModal').modal('show');--}}
{{--                },--}}
{{--                error: function(response) {--}}
{{--                    alert('An error occurred while fetching data. Please try again.');--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}

{{--        // Handle form submission via AJAX--}}
{{--        $('#commonForm').on('submit', function(e) {--}}
{{--            e.preventDefault();--}}

{{--            let actionUrl = $(this).attr('action');--}}
{{--            let formData = $(this).serialize();--}}

{{--            $.ajax({--}}
{{--                url: actionUrl,--}}
{{--                method: 'POST',--}}
{{--                data: formData,--}}
{{--                success: function(response) {--}}
{{--                    $('#commonModal').modal('hide');--}}
{{--                    location.reload(); // Or update the table dynamically--}}
{{--                },--}}
{{--                error: function(response) {--}}
{{--                    alert('An error occurred. Please try again.');--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

