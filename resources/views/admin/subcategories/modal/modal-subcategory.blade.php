<!-- Single Subcategory Modal for Add/Edit -->
<div class="modal fade" id="subcategoryModal" tabindex="-1" role="dialog" aria-labelledby="subcategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subcategoryModalLabel">Add Subcategory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include the Subcategory Form -->
                @include('admin.subcategories.modal.modal-form')
                {{-- @include('form-subcategory') --}}
            </div>
        </div>
    </div>
</div>
