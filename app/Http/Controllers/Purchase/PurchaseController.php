<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseFilterRequest;
use App\Http\Requests\StorePurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use App\Services\Product\ProductService;
use App\Services\Purchase\PurchaseService;
use App\Trait\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    use JsonResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = (new PurchaseService())->getProductss();
      //  dd($products);
        if(request()->ajax()) {
            try {
                return $this->successResponse($products, 'Successfully fetch Categories');
            } catch (\Exception $exception) {
                Log::channel('error log')->error('An error occurred : ' . $exception->getMessage());
                return $this->errorResponse($exception->getMessage());
            }
        }
            return view('admin.purchases.index')->with(['products' => $products]);
    }

    public function showPurchase(){
        $data['purchases'] = (new PurchaseService())->getAllPurchases(true);
        $data['products'] = (new ProductService())->getAllProducts();
        $data['suppliers']= (new ProductService())->getAllSuppliers();
        return view('admin.purchases.show-purchase')->with($data);
    }

    public function filterPurchase(StorePurchaseFilterRequest $request){
       // dd($request->validated());
            try{
                $data['purchases'] = (new PurchaseService())->getFilteredPurchases($request->validated());

              //  dd($data['purchases']);
                return $this->successResponse($data);
            }catch (\Throwable $exception){
                Log::channel('error log')->error('An error occurred : ' . $exception->getMessage());
                return $this->errorResponse($exception->getMessage());
            }
    }

    public function showPurchaseDues(){
        $purchases = (new PurchaseService())->getAllPurchases(true,null, '0');

        return view('admin.purchases.show-purchase-dues')->with(['purchases' => $purchases]);
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
    public function store(StorePurchaseRequest $request, PurchaseService $purchaseService)
    {
        try{
            DB::beginTransaction();

            $storePurchase              = $purchaseService ->storePurchase($request->except('_token', 'product_ids','cart_ids'));

            if($storePurchase) {

                $storeTransaction = $purchaseService->storeTransaction($storePurchase);

                $storePurchaseProduct   = $purchaseService ->storePurchaseProduct($storePurchase, $request->input('product_ids'));

                $productStock           = $purchaseService->productStock($storePurchase, $request->input('product_ids'));

                if($storePurchaseProduct && $productStock){

                   $purchaseService->deleteCartsItems($request->input('cart_ids'));

                }
            }
            DB::commit();
            return $this->successResponse($storePurchase, 'Successfully created Purchase');
        }catch (\Exception $exception){
            DB::rollBack();
            Log::channel('error log')->error('An error occurred : ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage());
        }
    }


    public function show(string $id, PurchaseService $purchaseService)
    {
        try{
            $data['purchaseProductDetails'] = $purchaseService->showPurchaseProductDetails($id);
            $data['supplierDetails']=$purchaseService->showSupplierDetails($id);

            $data['transactions'] = $purchaseService->showPurchaseTransection($id);

            return view('admin.purchases.show-product-details')->with($data);
        }catch (\Exception $exception){
            Log::channel('error log')->error('An error occurred : ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function showTransactions(string $id, PurchaseService $purchaseService){
        try{
           $transactions =  $purchaseService->showPurchaseTransection($id);

           return view('admin.purchases.show-transactions')->with(['transactions' => $transactions]);

        }catch (\Exception $exception){
            Log::channel('error log')->error('An error occurred : ' . $exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function printTransactions(string $id, PurchaseService $purchaseService){
       // dd($id);
        try{
            $data['transaction'] = $purchaseService->getPurchaseTransactions($id);
            // dd($data);
            return view('admin.purchases.print-purchase-transaction')->with($data);
        }catch(\Exception $e){
            Log::channel('error log')->error($e);
        }



//        try{
//            $data['transaction'] = $purchaseService->getTransactionHistory($id);
//
//            if($data['transaction']){
//                $transaction =  $data['transaction'][0];
//                $purchaseId = $transaction['purchase_id'];
//                // 0r  $purchaseId = $transaction->purchase_id;
//             //   dd($purchaseId);
//                $data['purchaseProductDetails'] = $purchaseService->showPurchaseProductDetails($purchaseId);
//                $data['purchase'] = $purchaseService->findPurchase($purchaseId);
//
//                $data['supplierDetails']=$purchaseService->showSupplierDetails($purchaseId);
//
//                $data['customerDetails']=$purchaseService->showCustomerDetails($purchaseId);
//             //   dd($data);
//            }
//            return view('admin.purchases.print-purchase-transaction')->with($data);
//        }catch (\Exception $exception){
//            Log::channel('error log')->error('An error occurred : ' . $exception->getMessage());
//        }
    }

}
