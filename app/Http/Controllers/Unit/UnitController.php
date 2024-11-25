<?php

namespace App\Http\Controllers\Unit;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitRequest;
use App\Services\Unit\UnitService;
use App\Trait\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UnitController extends Controller
{
    use JsonResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = (new UnitService())->getUnits(true);

        if(request()->ajax()){
            try{
                return $this->successResponse($units, 'Successfully fetched data');
            }catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage());
            }
        }
        return view('admin.units.index')->with(['units' => $units]);
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
    public function store(StoreUnitRequest $request, UnitService $unitService)
    {
        try{
            DB::beginTransaction();
            $unit = $unitService->storeUnit($request->validated());
            DB::commit();
        return $this->successResponse($unit, 'Successfully created data');
        }catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('error log')->error('An error occurred : ' .$th->getMessage());
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $unit = (new UnitService())->getUnitById($id);
            return $this->successResponse($unit, 'Successfully fetched data');
        }catch (\Throwable $th) {
            Log::channel('error log')->error('An error occurred : '. $th->getMessage());
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUnitRequest $request, UnitService $unitService, string $id)
    {
        try{
            DB::beginTransaction();
            $unit = $unitService->updateUnit( $id, $request->validated());
            DB::commit();
            return $this->successResponse($unit, 'Successfully updated data');
        }catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('error log')->error('An error occurred : '. $th->getMessage());
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, UnitService $unitService)
    {
     //   dd($id);
        try{
            DB::beginTransaction();
            $unit = $unitService->deleteUnit($id);
            DB::commit();

            return $this->successResponse($unit, 'Successfully deleted data');
        }catch (\Throwable $th) {
            Log::channel('error log')->error('An error occurred : '. $th->getMessage());
            return $this->errorResponse($th->getMessage());
        }
    }
}
