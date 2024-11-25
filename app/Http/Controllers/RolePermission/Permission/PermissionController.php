<?php

namespace App\Http\Controllers\RolePermission\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Services\Permission\PermissionService;
use App\Trait\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    use JsonResponse;

    public function __construct(){
        $this->middleware('permission:view permission',   ['only' => ['index']]);
        $this->middleware('permission:create permission', ['only' => ['create','store']]);
        $this->middleware('permission:update permission', ['only' => ['edit','update']]);
        $this->middleware('permission:delete permission', ['only' => ['destroy']]);
    }



    public function index()
    {
        try{
            $data['permissions'] = (new PermissionService())->getPermissions(true);
            if(request()->ajax()){
                return $this->successResponse($data, "Successfully fetch Permissions");
            }

            // dd($data);
            return view('admin.role-permission.permission.index')->with($data);
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }


    public function store(StorePermissionRequest $request, PermissionService  $permissionService)
    {
        try{
            $data['permission'] = $permissionService->storePermission($request->validated());
            return $this->successResponse($data, "Successfully create Permission");
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }



    public function edit(string $id)
    {
        try{
            $data['permission'] = (new PermissionService())->getPermissionById($id);
          //   dd($data);
            return $this->successResponse($data, "Successfully fetch a Permission");
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }


    public function update(StorePermissionRequest $request, string $id, PermissionService  $permissionService)
    {
        try{
            $data['permission'] = $permissionService->updatePermission($id, $request->validated());
            return $this->successResponse($data, "Successfully update Permission");
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }


    public function destroy( $id, PermissionService  $permissionService)
    {
        try{
            $data['permission'] = $permissionService->deletePermission($id);
            return $this->successResponse($data, "Successfully delete Permission");
        }catch(\Exception $exception){
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
