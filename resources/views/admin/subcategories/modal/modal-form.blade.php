<form id="subcategoryForm" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" id="subcategoryId" name="subcategoryId">

    <!-- Title -->
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') }}">
        <?= showError('title') ?>
    </div>

    <!-- Category -->
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select class="form-control" id="category" name="category_id" required>
            <!-- Options will be populated via AJAX -->
        </select>
        <?= showError('category_id') ?>
    </div>

    <!-- Position Number -->
    <div class="mb-3">
        <label for="position_no" class="form-label">Position Number</label>
        <input type="number" class="form-control" id="position_no" name="position_no" required value="{{ old('position_no') }}">
        <?= showError('position_no') ?>
    </div>

    <!-- Thumbnail -->
    <div class="mb-3">
        <label for="thumbnail" class="form-label">Thumbnail</label>
        <input type="file" class="form-control" id="thumbnail" name="thumbnail">
        <?= showError('thumbnail') ?>
    </div>

    <!-- Status -->
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="1" @selected(old('status') == 1)>Active</option>
            <option value="0" @selected(old('status') == 0)>Inactive</option>
        </select>
        <?= showError('status') ?>
    </div>

    <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
</form>
