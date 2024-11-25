<!-- Single Origin Modal for Add/Edit -->
<div class="modal fade" id="originModal" tabindex="-1" role="dialog" aria-labelledby="originModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="originModalLabel">Add Origin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include the Origin Form -->
                @include('admin.origins.modal.modal-form') <!-- Ensure this path is correct -->
                {{-- @include('form-origin') --}}
            </div>
        </div>
    </div>
</div>
