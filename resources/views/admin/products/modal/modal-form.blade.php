
<form id="productForm" method="POST" enctype="multipart/form-data">

    @csrf

    <input type="hidden" id="productId" name="productId">

    <!-- Product Images -->
    <div class="mb-3">
        <label for="thumbnail" class="form-label">Thumbnail</label>
        <input type="file" class="form-control" id="thumbnail" name="thumbnail" >
        <?= showError('thumbnail') ?>
    </div>

    <!-- Category -->
    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-control" id="category_id" name="category_id[]"  required multiple>
            <!-- Options will be populated via AJAX -->
        </select>
        <?= showError('category_id') ?>
    </div>

    <!-- Brand -->
    <div class="mb-3">
        <label for="brand_id" class="form-label">Brand</label>
        <select class="form-control" id="brand_id" name="brand_id" required>
            <!-- Options will be populated via AJAX -->
        </select>
        <?= showError('brand_id') ?>
    </div>

    <!-- Product Name -->
    <div class="mb-3">
        <label for="title" class="form-label">Title </label>
        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') }}">
        <?= showError('title') ?>
    </div>

    <!-- Description -->
    <div class="mb-3">
        <label for="short_description" class="form-label">Short Description</label>
        <textarea class="form-control" id="short_description" name="short_description" rows="3" required>{{ old('short_description') }}</textarea>
        <?= showError('short_description') ?>
    </div>
    <div class="mb-3">
        <label for="long_description" class="form-label">Long Description</label>
        <textarea class="form-control" id="long_description" name="long_description" rows="3" required>{{ old('long_description') }}</textarea>
        <?= showError('long_description') ?>
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

    <!-- Product Images -->
    <div class="mb-3">
        <label for="images" class="form-label">Product Images</label>
        <input type="file" class="form-control" id="images" name="images[]" multiple>
        <?= showError('images') ?>
    </div>

    <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
</form>
