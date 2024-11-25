<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Services\User\UserService;
use App\Trait\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    use JsonResponse;

//    public function __construct(){
//        $this->middleware('permission:view user',   ['only' => ['index']]);
//        $this->middleware('permission:create user', ['only' => ['create','store']]);
//        $this->middleware('permission:update user', ['only' => ['edit','update']]);
//        $this->middleware('permission:delete user', ['only' => ['destroy']]);
//    }

//    public function index(){
//        try{
//            $data['users']
//        }catch (\Exception $e){
//
//        }
//    }
    public function index(Request $request, UserService $userService)
    {
        $data['users'] = (new UserService())->getUsers(true, null,null, null, ['modelRole.role']);
      //  dd($data);
        if(request()->ajax()) {
            try {
                return $this->successResponse($data, "successfully fetched data");
            } catch (\Exception $e) {
                return $this->errorResponse($e->getMessage(), $e->getCode());
            }

        }

        return view('admin.users.allUser')->with($data);
    }



    public function create(UserService $userService){
        $data['roles'] = $userService->getRoles();
        return view('admin.users.create')->with($data);
    }

    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $userStore = (new UserService())->storeUser($request->validated());
            DB::commit();

            return redirect()->route('users.index')->with('status', 'User created successfully with roles.');

        } catch (\Throwable $exception) {
            DB::rollBack();

            // dd([
            //     $exception->getMessage(),
            //     $exception->getLine(),
            //     $exception->getFile(),
            // ]);

            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function edit(User $user,  UserService $userService)
    {
        try{
            $data['user'] = $user;
            $data['roles'] = $userService->getRoles();
            $data['userRoles'] = $user->roles->pluck('name','name')->all();
            return view('role-permission.user.edit')->with($data);

        }catch(\Throwable $exception){
            return redirect()->back()->with('error', $exception);
        }
    }


    public function update(Request $request, User $user,  UserService $userService)
    {
        try {

            $data = [
                'name'      => $request->name,
                'email'     => $request->email,
            ];

            if(!empty($request->password)){
                $data +=[
                    'password'  => Hash::make($request->password),
                ];
            }

            $user->update($data);

            $user->syncRoles($request->roles);

            return redirect()->route('users.index')->with('status', 'User updated successfully with  the roles.');

        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id,  UserService $userService)
    {
        try{
            $deleteUser = $userService->deleteUser($id);
        }catch(\Throwable $exception){
            return redirect()->back()->with('error', $exception);
        }
    }





//    --------------


    public function admin(){
        $data['admin'] = (new UserService())->getUsers(true, null,'1');

        if(request()->ajax()){
            try{
                return $this->successResponse($data, "successfully fetched data");
            }catch(\Exception $e){
                return $this->errorResponse($e->getMessage(), $e->getCode());
            }

        }
        return view('admin.users.admin')->with('admin', $data);
    }

    public function customer(){
        $data['customers'] = (new UserService())->getUsers(true, null, '0');

        if(request()->ajax()){
            try{
                return $this->successResponse($data, "successfully fetched data");
            }catch(\Exception $e){
                return $this->errorResponse($e->getMessage(), $e->getCode());
            }
        }
        return view('admin.users.customer')->with($data);
    }



    public function supplier(){
        $data['suppliers'] = (new UserService())->getUsers(true, null,'2');

        if(request()->ajax()){
            try{
                return $this->successResponse($data, "successfully fetched data");
            }catch(\Exception $e){
                return $this->errorResponse($e->getMessage(), $e->getCode());
            }
        }
        return view('admin.users.supplier')->with($data);
    }


    public function customerInfo(){
        $customers = (new UserService())->customerDetails();

        try{
            return $this->successResponse($customers, "successfully fetched data");
        }catch(\Exception $e){
            Log::channel('error log')->error($e);
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }



}
