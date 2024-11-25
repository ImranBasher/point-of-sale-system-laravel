<?php

namespace App\Http\Controllers\SalesCart;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalesCartRequest;
use App\Services\Cart\CartService;
use App\Services\SalesCart\SalesCartService;
use App\Trait\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesCartController extends Controller
{
    use JsonResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesCarts = (new SalesCartService())->getSalesCarts(
            true, null, null , ['product']
        );

        // dd($carts);
        try{
            return $this->successResponse($salesCarts, 'Successfully Fetch Sales Carts' );
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e);
        }
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
    public function store(StoreSalesCartRequest $request, SalesCartService  $salesCartService)
    {
        try{
            DB::beginTransaction();
            $salesCart = $salesCartService->storeSalesCart($request->validated());
            DB::commit();
            return $this->successResponse($salesCart, 'Successfully Created Sales Cart' );
        }catch(\Throwable $th){
            DB::rollBack();
            Log::channel('errorLog')->error($th->getMessage());
            return $this->errorResponse($th->getMessage(), $th);
        }
    }


    public function show( $id, SalesCartService  $salesCartService)
    {
        try{
            $salesCart = $salesCartService->getSalesCartByProductId($id);
            //  dd($cart);
            if (!$salesCart) {
                // Return a 404 response if cart not found
                return $this->errorResponse('Sales Cart not found', null, false, 404);
            }
            return $this->successResponse($salesCart, 'Successfully Fetch Sales Cart' );
        }catch(\Throwable $th){
            Log::channel('errorLog')->error($th->getMessage());
            return $this->errorResponse($th->getMessage(), $th);
        }
    }


    public function edit(string $id, SalesCartService  $salesCartService )
    {
        try{
            $salesCart = $salesCartService->getSalesCartById($id);
            return $this->successResponse($salesCart, 'Successfully Fetch Sales Cart' );
        }catch(\Throwable $th){
            Log::channel('errorLog')->error($th->getMessage());
            return $this->errorResponse($th->getMessage(), $th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSalesCartRequest $request, string $id, SalesCartService  $salesCartService)
    {
       // dd($request->all());
        try{
            DB::beginTransaction();
            $salesCart = $salesCartService->updateSalesCart($id, $request->validated());
            DB::commit();
            return $this->successResponse($salesCart, 'Successfully Updated Sales Cart' );
        }catch(\Throwable $th){
            DB::rollBack();
            Log::channel('errorLog')->error($th->getMessage());
            return $this->errorResponse($th->getMessage(), $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, SalesCartService  $salesCartService)
    {
        // dd($id);
        try{
            DB::beginTransaction();
            $salesCart = $salesCartService->deleteSalesCart($id);
            DB::commit();
            return $this->successResponse($salesCart, 'Successfully Delete Cart' );
        }catch(\Throwable $th){
            DB::rollBack();
            Log::channel('errorLog')->error($th->getMessage());
            return $this->errorResponse($th->getMessage(), $th);
        }
    }
}
