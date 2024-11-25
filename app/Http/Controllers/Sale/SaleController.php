<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\StoreSalesFilterRequest;
use App\Services\Purchase\PurchaseService;
use App\Services\Sale\SaleService;
use App\Trait\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    use JsonResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = (new SaleService())->getProducts(true, null, null, ['productStock','purchaseProduct']);
          //  dd($products);
        if(request()->ajax()) {
            try {
                return $this->successResponse($products, 'Successfully fetch data');
            } catch (\Exception $e) {
                Log::channel('error log')->error($e);
                return $this->errorResponse($e->getMessage(), $e);
            }
        }
        return view('admin.sales.index')->with('products', $products);
    }
    public function showSales(){
        $data['sales'] = (new SaleService())->getAllSales(true);
        $data['products'] = (new SaleService())->getAllProducts();
        $data['customers']= (new SaleService())->getAllCustomers();
        return view('admin.sales.show-sales')->with($data);
    }

    public function filterSales(StoreSalesFilterRequest $request){
        try{
            $data['sales'] = (new SaleService())->getFilteredSales($request->validated());

            //  dd($data['sales']);
            return $this->successResponse($data);
        }catch (\Throwable $exception){
            Log::channel('error log')->error('An error occurred : ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage());
        }
    }



    public function showSalesDues(){
        $sales = (new SaleService())->getAllSales(true, null, '0');

        return view('admin.sales.show-sales-dues')->with(['sales' => $sales]);
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
    public function store(StoreSaleRequest $request, SaleService  $saleService )
    {
      //  dd($request->all());
        try{
            DB::beginTransaction();
            $storeSales = $saleService->storeSales($request->except('_token', 'product_ids','sales_cart_ids'));

            if($storeSales){
                $storeTransaction = $saleService->storeTransaction($storeSales);
                $storeSalesProduct = $saleService->storeSalesProduct($storeSales,$request->input('product_ids'));

                $updateProductStock = $saleService->updateProductStock( $request->input('product_ids'));

                if($storeSalesProduct && $updateProductStock){
                    $saleService->deleteSalesCartItems($request->input('sales_cart_ids'));
                }
            }
            DB::commit();
            return $this->successResponse($storeSales, 'Successfully create data');

        }catch (\Exception $e) {
            DB::rollBack();
            Log::channel('error log')->error($e);
            return $this->errorResponse($e->getMessage(), $e);
        }
    }

    public function show(string $id, SaleService  $saleService)
    {
        try{
            $data['salesProductDetails'] = $saleService->showSalesProductDetails($id);
           // $data['supplierDetails']=$saleService->showSupplierDetails($id);

            $data['transactions'] = $saleService->showSalesTransection($id);

            return view('admin.sales.show-sales-details')->with($data);
        }catch (\Exception $exception){
            Log::channel('error log')->error('An error occurred : ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function showTransactions(string $id, SaleService  $saleService){
        try{
            $transactions =  $saleService->showSalesTransection($id);
           // dd($transactions);
            return view('admin.sales.show-transactions')->with(['transactions' => $transactions]);

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

    public function printTransactions(string $id, SaleService  $saleService)
    {
        try{
            $data['transaction'] = $saleService->getTransactionHistory($id);
           // dd($data);
            return view('admin.sales.print-sales-transaction')->with($data);
        }catch(\Exception $e){
            Log::channel('error log')->error($e);
        }
    }
}
