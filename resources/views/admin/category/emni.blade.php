
{{--@extends('admin.layout.main')--}}

{{--@section('content')--}}
{{--    <div class="container-fluid px-4">--}}

{{--        <!-- Card for Categories -->--}}
{{--        <div class="card mt-4 shadow-sm">--}}
{{--            <div class="card-header">--}}
{{--                <h4 class="mb-0">--}}
{{--                    Categories--}}
{{--                    <a href="#" class="btn btn-primary float-end addButton" data-entity="category">Add a Category</a>--}}
{{--                </h4>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <div class="table-responsive">--}}
{{--                    @isset($categories)--}}
{{--                        <table class="table table-striped table-bordered">--}}
{{--                            <thead>--}}
{{--                            <tr id="table-headers">--}}
{{--                                <th>ID</th>--}}
{{--                                <th>Name</th>--}}
{{--                                <th>Status</th>--}}
{{--                                <th>Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody id = "table-body">--}}
{{--                            @php $i = 1 @endphp--}}
{{--                            @foreach($categories as $category)--}}
{{--                                <tr>--}}
{{--                                    <td>{{$i++}}</td>--}}
{{--                                    <td>{{$category->name}}</td>--}}
{{--                                    <td>{{$category->status ? 'Active' : 'Inactive'}}</td>--}}
{{--                                    <td>--}}
{{--                                        <a href="#" class="btn btn-info btn-sm editButton"--}}
{{--                                           data-entity="category"--}}
{{--                                           data-id="{{ $category->id }}">--}}
{{--                                            Edit--}}
{{--                                        </a>--}}
{{--                                        <a href="{{ route('categories.destroy', $category->id) }}" class="btn btn-danger btn-sm deleteButton">Delete</a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    @endisset--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--        @include('admin.includes.modal_box')--}}
{{--        @include('admin.category.category_js')--}}
{{--    </div>--}}


{{--@endsection--}}



{{--// Function to load categories--}}
{{--function loadCategories() {--}}
{{--    const url = '{{ route("categories.index") }}';--}}
{{--    $.ajax({--}}
{{--        url: '{{ route("categories.index") }}',--}}
{{--        type: 'GET',--}}
{{--        dataType: 'json',--}}
{{--        success: function(response) {--}}
{{--            if (response.status === 200) {--}}
{{--                // Clear existing table rows--}}
{{--                $('#table-body').empty();--}}
{{--                // Loop through categories and append to table--}}
{{--                $.each(response.data, function(key, category) {--}}
{{--                    $('#table-body').append(--}}
{{--                        '<tr>' +--}}
{{--                        '<td>' + category.id + '</td>' +--}}
{{--                        '<td>' + category.name + '</td>' +--}}
{{--                        '<td>' + (category.status ? 'Active' : 'Inactive') + '</td>' +--}}
{{--                        '<td>' +--}}
{{--                        '<a href="#" class="editButton btn btn-warning" data-id="' + category.id + '">Edit</a>' +--}}
{{--                        ' ' +--}}
{{--                        '<a href="#" class="delete-btn btn btn-danger" data-id="' + category.id + '">Delete</a>' +--}}
{{--                        '</td>' +--}}
{{--                        '</tr>'--}}
{{--                    );--}}
{{--                });--}}

{{--                // Bind click events for edit and delete buttons--}}
{{--                $('.editButton').click(function(e) {--}}
{{--                    e.preventDefault();--}}
{{--                    let id = $(this).data('id');--}}
{{--                    // Handle edit action--}}
{{--                    console.log('Edit category with ID:', id);--}}
{{--                    // You can redirect to an edit page or show a modal here--}}
{{--                });--}}

{{--                $('.delete-btn').click(function(e) {--}}
{{--                    e.preventDefault();--}}
{{--                    let id = $(this).data('id');--}}
{{--                    // Handle delete action--}}
{{--                    console.log('Delete category with ID:', id);--}}
{{--                    // You can send an AJAX request to delete the category--}}
{{--                });--}}
{{--            } else {--}}
{{--                alert(response.message);--}}
{{--            }--}}
{{--        },--}}
{{--        error: function(xhr) {--}}
{{--            alert('An error occurred while fetching categories.');--}}
{{--        }--}}
{{--    });--}}
{{--}--}}
{{--$('#addCategoryModal').modal('hide');--}}
{{--$('#editCategoryModal').modal('hide');--}}

{{--// Call the function to load categories when the page is ready--}}
{{--loadCategories();--}}


{{--$('#openModalButton').on('click', function() {--}}
{{--    $('#addCategoryModal').modal('show');--}}
{{--});--}}

{{--// Handle form submission with AJAX--}}
{{--$('#addCategoryForm').on('submit', function(event) {--}}
{{--    event.preventDefault(); // Prevent the form from submitting normally--}}

{{--    $.ajax({--}}
{{--        url: "{{ route('categories.store') }}", // Use the Laravel route helper to generate the URL--}}
{{--        method: 'POST',--}}
{{--        data: $(this).serialize(), // Serialize the form data--}}
{{--        success: function(response) {--}}
{{--            if (response.status) {--}}
{{--                $('#addCategoryModal').modal('hide'); // Hide the modal--}}
{{--                loadCategories(); // Call loadCategories to refresh the category list--}}
{{--            } else {--}}
{{--                alert(response.message);--}}
{{--            }--}}
{{--        },--}}
{{--        error: function(xhr, status, error) {--}}
{{--            // Handle error - you can show an error message--}}
{{--            alert('An error occurred: ' + error);--}}
{{--        }--}}
{{--    });--}}
{{--});--}}

// });


try {
$categories = Category::all(); // Fetch all categories
return response()->json([
'status' => true,
'code' => 200,
'data' => $categories
]);
} catch (\Throwable $exception) {
return response()->json([
'status' => false,
'code' => 500,
'message' => 'An error occurred while fetching categories.',
'error' => $exception->getMessage()
]);
}


public function index()
{
$categories = (new CategoryService())->getCategories(true);
// Check if the request is an AJAX request
if (request()->ajax()) {
return $this->successResponse($categories, 'Category Created successfully!');
}
return view('admin.category.categories')->with(['categories' => $categories]);
}
