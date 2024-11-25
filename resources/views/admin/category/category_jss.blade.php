<script src="{{asset('backend/custom.js') }}"></script>
<script>
    $(document).ready(function() {

   // ----------------------------------------------------------------

        $('.addButton').on('click', function(e){
            e.preventDefault();
            $('#main-modal-body').empty();

            $('#main-modal-body').append(`
            <form id="commonForm" action="{{ route('categories.store') }}" method="POST">
                @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" id="submitButton">Save changes</button>
        </form>
`);
            $('#commonModal').modal('show');

        });

    // ----------------------------------------------------------------

        $('#commonForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var url = "{{ route('categories.store') }}";

            ajaxRequest(
                url,
                formData,
                function(response) {
                    console.log("Category added successfully:", response);
                    $('#commonModal').modal('hide');
                    loadData('/categories', {}, renderTable);
                },
                function(errorResponse) {
                    console.error("Error adding category:", errorResponse);
                }
            );
        });

    // -----------------------------------------------------------
        $('.editButton').on('click', function(e){
            e.preventDefault();
            const categoryId = $(this).data('id');

            // Clear modal body
            $('#main-modal-body').empty();
            let url = '/categories/{categoryId}/edit';
            // Fetch category data via AJAX
            $.ajax({
                url: url,  // Assuming you have a route for fetching the edit form
                method: 'GET',
                success: function(response) {

                    if(response.status && response.code === 200) {

                        // Populate the modal with the category data
                        $('#main-modal-body').append(`
                    <form id="commonForm" action="/categories/${response.data.id}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <input type="hidden" id = "id" name = "id" value = "${response.data.id}">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="${response.name}">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" ${response.data.status == 1 ? 'selected' : ''}>Active</option>
                                <option value="0" ${response.data.status == 0 ? 'selected' : ''}>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateButton">Save changes</button>
                    </form>
                `);
                        $('#commonModal').modal('show');
                    }
                },
                error: function(err) {
                    alert('Error fetching category data');
                }
            });
        });
   // ----------------------------------------------------------------
    });

     loadData('/categories', {}, renderTable);
</script>
