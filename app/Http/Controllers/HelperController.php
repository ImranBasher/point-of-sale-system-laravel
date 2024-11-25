<?php

namespace App\Http\Controllers;

use App\Services\Helper\HelperService;
use App\Trait\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HelperController extends Controller
{
    use JsonResponse;
    public function  users(){
         $users = (new HelperService())->getUsers();
         try{
             return $this->successResponse($users, 'Success get users');
         }catch(\Exception $e){
             Log::channel('error')->error($e->getMessage());
             return $this->errorResponse($e->getMessage(), $e);
         }
    }
}
