<?php
namespace App\Services\User;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService{

    public function getUsers(
        $paginatePluckOrGet = null,
        $onlyActive = null,
        $role = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null
    ){
        $query = User::query();

        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if (!is_null($onlyActive)) {
            $query->where('status', $onlyActive);
        }
        if (!is_null($role)) {
            $query->where('role', $role);
        }
        if (is_null($paginatePluckOrGet)) {
            return $query->pluck('id', 'name');
        }
        return $paginatePluckOrGet ? $query->paginate(20) : $query->get();
    }

    public function customerDetails(){
        return User::query()
            ->where('id', '!=', userId())
            ->where('role', '!=', '1')
            ->get();
    }


    public function getRoles(){
        return Role::pluck('name','name')->all();
    }


    public function storeUser(array $payload) {
        // dd($payload);
        $payload['password'] = Hash::make($payload['password']);
        $user = User::create([
            'name'      => $payload['name'],
            'email'     => $payload['email'],
            'password'  => $payload['password'],
        ]);
        $roles = $user->syncRoles($payload['roles']);
        return $user;
    }

    public function getAUser($id){
        return User::query()->findOrFail($id);
    }

    public function deleteUser($userId){
        $user = $this->getAUser($userId);
        return $user->delete();

        // model_has_roles table data will auto delete according to User Id.
    }
}
