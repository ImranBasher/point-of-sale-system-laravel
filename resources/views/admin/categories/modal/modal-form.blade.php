<form id="categoryForm"  method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" id="categoryId" name="categoryId">

    <!-- Title -->
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') }}">
        <?= showError('title') ?>
    </div>

    <!-- Parent Category (Optional) -->
    <div class="mb-3">
        <label for="parent_category" class="form-label">Parent Category</label>
        <select class="form-control" id="parent_category" name="parent_category_id">
            <option value="">Select Parent Category</option>
            <!-- Options will be populated via AJAX or server-side rendering -->
        </select>
        <?= showError('parent_category_id') ?>
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
