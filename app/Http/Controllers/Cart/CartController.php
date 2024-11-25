<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Models\Cart;
use App\Services\Cart\CartService;
use App\Trait\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    use JsonResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $carts = (new CartService())->getCarts(
            true, null, null , ['product']
        );

       // dd($carts);
        try{
            return $this->successResponse($carts, 'Successfully Fetch Carts' );
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e);
        }
    }

    public function users(){
        $users = (new CartService())->getUsers();
        try{
            return $this->successResponse($users, 'Successfully Fetch Carts' );
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), $e);
        }
    }


//array:15 [ // app\Http\Controllers\Purchase\PurchaseController.php:48
//"_token" => "uk4Vlq3eJYusDc7KbjnuWk3VbYbEg7AbD5wlsbhk"
//"product_ids" => array:2 [
//0 => "1"
//1 => "2"
//]
//"supplier_id" => "3"
//"sub_total" => "350"
//"discount_type" => "2"
//"discount_value" => "83"
//"discount_amount" => "290.50"
//"shipping_amount" => "73"
//"vat_amount" => "82"
//"tax_amount" => "0"
//"grand_total" => "108.29"
//"paid_amount" => "68"
//"total_quantity" => "17"
//"payment_status" => "0"
//"status" => "0"
//]

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
    public function store(StoreCartRequest $request, CartService $cartService)
    {

      // dd($request->all());
        try{
            DB::beginTransaction();
            $cart = $cartService->storeCart($request->validated());
            DB::commit();
            return $this->successResponse($cart, 'Successfully Created Cart' );
        }catch(\Throwable $th){
            DB::rollBack();
            Log::channel('errorLog')->error($th->getMessage());
            return $this->errorResponse($th->getMessage(), $th);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id, CartService $cartService)
    {
       // dd($id);
        try{
            $cart = $cartService->getCartByProductId($id);
          //  dd($cart);
            if (!$cart) {
                // Return a 404 response if cart not found
                return $this->errorResponse('Cart not found', null, false, 404);
            }
            return $this->successResponse($cart, 'Successfully Fetch Cart' );
        }catch(\Throwable $th){
            Log::channel('errorLog')->error($th->getMessage());
            return $this->errorResponse($th->getMessage(), $th);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, CartService $cartService)
    {
        try{
            $cart = $cartService->getCartById($id);
           // dd();
            return $this->successResponse($cart, 'Successfully Fetch Cart' );
        }catch(\Throwable $th){
            Log::channel('errorLog')->error($th->getMessage());
            return $this->errorResponse($th->getMessage(), $th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCartRequest $request, string $id, CartService $cartService)
    {
     //  dd($request->all());
        try{
            DB::beginTransaction();
            $cart = $cartService->updateCart($id, $request->validated());
            DB::commit();
            return $this->successResponse($cart, 'Successfully Updated Cart' );
        }catch(\Throwable $th){
            DB::rollBack();
            Log::channel('errorLog')->error($th->getMessage());
            return $this->errorResponse($th->getMessage(), $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, CartService $cartService)
    {
       // dd($id);
        try{
            DB::beginTransaction();
            $cart = $cartService->deleteCart($id);
            DB::commit();
            return $this->successResponse($cart, 'Successfully Delete Cart' );
        }catch(\Throwable $th){
            DB::rollBack();
            Log::channel('errorLog')->error($th->getMessage());
            return $this->errorResponse($th->getMessage(), $th);
        }
    }
}
