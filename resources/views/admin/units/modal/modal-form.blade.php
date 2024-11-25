<!-- resources/views/admin/units/modal/modal-form.blade.php -->

<form id="unitForm" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" id="unitId" name="unitId">

    <!-- Unit Name -->
    <div class="mb-3">
        <label for="unit_name" class="form-label">Unit Name</label>
        <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
        <?= showError('name') ?>
    </div>

    <!-- Status -->
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="1" @selected(old('status') == '1')>Active</option>
            <option value="0" @selected(old('status') == '0')>Inactive</option>
        </select>
        <?= showError('status') ?>
    </div>

    <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
</form>
