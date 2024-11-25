<?php

namespace App\Http\Controllers\RolePermission\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\StorePermissionToRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Services\Permission\PermissionService;
use App\Services\Role\RoleService;
use App\Trait\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
//    public function __construct(){
//        $this->middleware('permission:view role',   ['only' => ['index']]);
//        $this->middleware('permission:create role', ['only' => ['create','store',]]);
//        $this->middleware('permission:update role', ['only' => ['edit','update']]);
//        $this->middleware('permission:delete role', ['only' => ['destroy']]);
//    }
    use JsonResponse;
    public function index()
    {
        try{
            $data['roles'] = (new RoleService())->getRoles(true);
            if(request()->ajax()){
               return $this->successResponse($data, "Successfully fetch roles");
             }

           // dd($data);
            return view('admin.role-permission.role.index')->with($data);
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }


    public function store(StoreRoleRequest $request, RoleService  $roleService)
    {
        try{
            $data['role'] = $roleService->storeRole($request->validated());
            return $this->successResponse($data, "Successfully create role");
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }


    public function show(Role $id)
    {

    }


    public function edit(string $id)
    {
        try{
            $data['role'] = (new RoleService())->getRoleById($id);
           // dd($data);
            return $this->successResponse($data, "Successfully fetch a role");
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }


    public function update(StoreRoleRequest $request, string $id, RoleService  $roleService)
    {
        try{
            $data['role'] = $roleService->updateRole($id, $request->validated());
            return $this->successResponse($data, "Successfully update role");
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }


    public function destroy( $id, RoleService  $roleService)
    {
        try{
            $data['role'] = $roleService->deleteRole($id);
            return $this->successResponse($data, "Successfully delete role");
        }catch(\Exception $exception){
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function addPermissionToRole($roleId, RoleService $roleService){
        $data['role'] = $roleService->getARole($roleId);
        $data['permissions'] = (new PermissionService())->getAllPermissions();
        $data['rolePermissions'] = $roleService->rollPermissions($roleId);
        return view('admin.role-permission.role.add-permission')->with($data);
    }

    public function givePermissionToRole(StorePermissionToRoleRequest $request, $roleId, RoleService $roleService){
        try{
          //  dd($request);
            $role = $roleService->getARole($roleId);
          //  dd($role);
            $role->syncPermissions($request->permission); // store all permission at a time
            return redirect('roles')->with('status', 'Permission added to role');
        }catch(\Throwable $e){
            return redirect()->back()->with('status', $e);
        }
    }
}
