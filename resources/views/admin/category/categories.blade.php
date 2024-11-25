@extends('admin.layout.main')

@section('content')
    <div class="container-fluid px-4">

        <!-- Card for Categories -->
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">
                    Categories
                    <a href="#" class="btn btn-primary float-end addButton" data-entity="category">Add a Category</a>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr id="table-headers">
                            <!-- Dynamic headers will be populated by JS -->
                        </tr>
                        </thead>
                        <tbody id="table-body">
                        <!-- Dynamic rows will be populated by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal for forms -->
        @include('admin.includes.modal_box')

    </div>
@endsection
