<?php
namespace app\services\Role;

use App\Models\RoleHasPermission;
use Spatie\Permission\Models\Role;

class RoleService{
    public function getRoles(
        $paginatePluckOrGet = null,
        $onlyActive = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null
    ){
        $query = Role::query();
        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if (!is_null($onlyActive)) {
            $query->where('status', $onlyActive);
        }
        if (is_null($paginatePluckOrGet)) {
            return $query->pluck('id', 'name');
        }
        return $paginatePluckOrGet ? $query->paginate(20) : $query->get();
    }


    public function getRoleById($id){
        return Role::query()->findOrFail($id);
    }

    public function storeRole(array $payload){
        return Role::query()->create($payload);
    }



    public function updateRole( $id, array $payload){
        $role = $this->getRoleById($id);
        return $role->update($payload);
    }


    public function deleteRole($id){
        $role = $this->getRoleById($id);
        return $role->delete();
    }


   //----------------------------------------------------------


    public function getARole($id){
        return Role::query()->find($id);
    }

    public function rollPermissions($roleId){
        return RoleHasPermission::query()->where('role_id', $roleId)->get();
    }




}
