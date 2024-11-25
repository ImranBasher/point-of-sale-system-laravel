
<form id="roleForm" method="POST" >
    @csrf
    <input type="hidden" id="roleId" name="roleId">

    <div class="mb-3">
        <label for="name" class="form-label">Role Name</label>
        <input type="text" class="form-control" id="name" name="name" >
        <?= showError('name') ?>
    </div>
    <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
</form>
