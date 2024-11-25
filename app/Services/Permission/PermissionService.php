<?php

namespace App\Services\Permission;

use Spatie\Permission\Models\Permission;

class PermissionService{
    public function getPermissions(
        $paginatePluckOrGet = null,
        $onlyActive = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null
    ){
        $query = Permission::query();
        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if (!is_null($onlyActive)) {
            $query->where('status', $onlyActive);
        }
        if (is_null($paginatePluckOrGet)) {
            return $query->pluck('id', 'name');
        }
        return $paginatePluckOrGet ? $query->paginate(40) : $query->get();
    }

    public function getAllPermissions(){
        return Permission::query()->get();
    }
    public function getPermissionById($id){
        return Permission::query()->findOrFail($id);
    }

    public function storePermission(array $payload){
        return Permission::query()->create($payload);
    }



    public function updatePermission( $id, array $payload){
        $role = $this->getPermissionById($id);
        return $role->update($payload);
    }


    public function deletePermission($id){
        $role = $this->getPermissionById($id);
        return $role->delete();
    }



}
