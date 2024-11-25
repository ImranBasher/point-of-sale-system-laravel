<?php

namespace App\Http\Controllers\Dues;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDuesPurchaseRequest;
use App\Services\DuesPurchase\DuesPurchaseService;
use App\Trait\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class DuesPurchaseController extends Controller
{
    use JsonResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['duesPurchases'] =  (new DuesPurchaseService())->getDuesPurchase(true, '0');

        return view('admin.dues.purchases.dues-purchase')->with($data);
    }

    public function showPurchasePayment(){
        return view('admin.dues.purchases.due-pay');
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

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, )
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id,DuesPurchaseService $duePurchaseService)
    {
        try{
            $purchase = $duePurchaseService->purchaseAccordingToInvoice($id);
            return $this->successResponse($purchase, 'Successfully fetch purchase according to invoice');
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return $this->errorResponse($exception->getMessage(),$exception );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( StoreDuesPurchaseRequest $request, string $id, DuesPurchaseService $duePurchaseService)
    {
    //    dd($request->all());
        try{
            $validatedData = $request->validated();
            $updatePurchase = $duePurchaseService->updatePayPurchase($id, $request->validated());
            if($updatePurchase[0]){
                $duePurchaseService->storeTransaction($updatePurchase[1], $validatedData['paid_amount']);
            }
            return redirect()->back()->with('success', 'Purchase payment updated successfully');
        }catch (\Throwable $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the purchase.');
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
