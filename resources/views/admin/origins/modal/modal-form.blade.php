<form id="originForm" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" id="originId" name="originId">

    <!-- Origin Name -->
    <div class="mb-3">
        <label for="origin_name" class="form-label">Origin Name</label>
        <input type="text" class="form-control" id="origin_name" name="origin_name" required value="{{ old('origin_name') }}">
        <?= showError('origin_name') ?>
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
