<?php

namespace App\Http\Controllers\Dues;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDuesSaleRequest;
use App\Services\DuesSales\DuesSalesService;
use App\Trait\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DuesSelesController extends Controller
{
    use JsonResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['duesSales'] =  (new DuesSalesService())->getDuesSales(true, '0');

        return view('admin.dues.sales.due-sales')->with($data);
    }
    public function showSalesPayment(){
        return view('admin.dues.sales.due-sales-pay');
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
    public function store(Request $request)
    {
        //
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
    public function edit(string $id, DuesSalesService $duesSalesService)
    {
        try{
            $purchase = $duesSalesService->salesAccordingToInvoice($id);
            return $this->successResponse($purchase, 'Successfully fetch sale according to invoice');
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return $this->errorResponse($exception->getMessage(),$exception );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDuesSaleRequest $request, string $id, DuesSalesService  $duesSalesService)
    {
      //  dd($request->all());
        try{
            $validatedData = $request->validated();
            $updateSale = $duesSalesService->updatePaySale($id, $request->validated());
           // dd($updateSale);
            if($updateSale[0]){
               // dd($updateSale);
                $duesSalesService->storeTransaction($updateSale[1], $validatedData['paid_amount']);
            }
            return redirect()->back()->with('success', 'Sale payment updated successfully');

        }catch (\Throwable $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the sale.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
