
<form id="permissionForm" method="POST" >
    @csrf
    <input type="hidden" id="permissionId" name="permissionId">

    <div class="mb-3">
        <label for="name" class="form-label">Permission Name</label>
        <input type="text" class="form-control" id="name" name="name" >
        <?= showError('name') ?>
    </div>
    <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
</form>
