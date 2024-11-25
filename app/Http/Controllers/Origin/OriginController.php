<?php

namespace App\Http\Controllers\Origin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOriginRequest;
use App\Services\Origin\OriginService;
use App\Trait\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OriginController extends Controller
{
    use JsonResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $origins = (new OriginService())->getOrigins(true);

        if(request()->ajax()) {
            try{
                return $this->successResponse($origins,'Successfully fetch the Origins');
            }catch (\Throwable $exception) {
                return $this->errorResponse($exception->getMessage(), $exception);
            }
        }
        return view ('admin.origins.index')->with(['origins'=> $origins]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOriginRequest $request, OriginService  $originService)
    {
        try{
            DB::beginTransaction();
            $origin = $originService->storeOrigin($request->validated());
            DB::commit();
            return $this->successResponse($origin, "Successfully created Origin");
        }catch(\Throwable $e){
            DB::rollBack();
            Log::channel('error log')->error('An error occurred while creating Origin: '.$e->getMessage());
            return $this->errorResponse($e->getMessage(), $e);
        }
    }

    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $origin = (new OriginService())->getOriginById($id);
            return $this->successResponse($origin, "Successfully fetch the Origin");
        }catch(\Throwable $e){
            Log::channel('error log')->error('An error occurred while fetching Origin: '.$e->getMessage());
            return $this->errorResponse($e->getMessage(), $e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOriginRequest $request, OriginService  $originService, string $id)
    {
        try{
            DB::beginTransaction();
            $origin = $originService->updateOrigin($id,  $request->validated());
            DB::commit();
            return $this->successResponse($origin, "Successfully updated Origin");
        }catch(\Throwable $e){
            DB::rollBack();
            Log::channel('error log')->error('An error occurred while updating Origin: '.$e->getMessage());
            return $this->errorResponse($e->getMessage(), $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, OriginService $originService)
    {
        try{
            DB::beginTransaction();
            $origin = $originService->deleteOrigin($id);
            DB::commit();
            return $this->successResponse($origin, "Successfully deleted Origin");
        }catch (\Throwable $e){
            DB::rollBack();
            Log::channel('error log')->error('An error occurred while deleting Origin: '.$e->getMessage());
            return $this->errorResponse($e->getMessage(), $e);
        }
    }
}
