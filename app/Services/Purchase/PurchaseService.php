<?php

namespace App\Services\Purchase;


use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Transaction;
use App\Services\Transaction\TransactionService;

class PurchaseService{

    public function getProductss()
    {
        return Product::query()
            ->where('status', '1')
            ->with(['categories', 'brand', 'productPictures'])
            ->get();

    }
    public function storePurchase(array $payload){
        $payload['invoice_no'] = $this->generateInvoiceNumber();
        $payload['customer_id'] = userId();
        $payload['due_amount'] = $payload['grand_total'] - $payload['paid_amount'];
        return Purchase::query()->create($payload);
    }

    public function getAllPurchases(
        $paginatePluckOrGet = null,
        $onlyActive = null,
        $onlyDues = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null)
    {
        $query = Purchase::query();

        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if (!is_null($onlyActive)) {
            $query->where('status', $onlyActive);
        }
        if (!is_null($onlyDues)) {
            $query->where('payment_status', $onlyDues);
        }
        if (is_null($paginatePluckOrGet)) {
            return $query->pluck('id', 'name');
        }
        return $paginatePluckOrGet ? $query->paginate(20) : $query->get();
    }


    /// Filtering
    public function getFilteredPurchases(array $payload){

      //  dd($payload);
        $supplierId     = $payload['supplier_id'];
        $productId      = $payload['product_id'];
        $startDate      = $payload['start_date'];
        $endDate        = $payload['end_date'];

        $purchases = Purchase::query();

        if (!is_null($supplierId)) {
            $purchases->where('supplier_id',  strval($supplierId));
        }

        if(!empty($productId)) {
            $purchases->whereHas('purchase_product', function($query) use ($productId) {
                $query->where('product_id', $productId);
            });
        }

        if(!empty($startDate && $endDate)) {
            $purchases->whereBetween('created_at', [$startDate, $endDate]);
        }
        return $purchases->get();
    }


    public function showPurchaseProductDetails($purchaseId){
        return PurchaseProduct::query()
            ->where('purchase_id', $purchaseId)->with('product')
            ->get();
    }

    public function showPurchaseTransection($purchaseId){
        return Transaction::query()
            ->where('purchase_id', $purchaseId)
            ->with('purchase')
            ->get();
    }

    public function showSupplierDetails($purchaseId){
        return Purchase::query()->where('id', $purchaseId)
            ->with('supplier')
            ->get();
    }

    public function storeTransaction($purchase){
       // dd($purchase);
        $data['purchase_id'] = $purchase->id;
        $data['amount'] = $purchase->paid_amount;
        $dueAmount = $purchase->grand_total - $purchase->paid_amount;
        $data['note'] = "Your due amount is : $dueAmount";
        $data['customer_id'] = $purchase->supplier_id;

        return (new TransactionService())->transactionInsertOrUpdate($data);
    }

    private function generateInvoiceNumber()
    {
        $latestPurchase = Purchase::latest('id')->first();
        // If there is no purchase yet, start from 1
        $newInvoiceNumber = $latestPurchase ? $latestPurchase->id + 1 : 1;
        // Return the invoice number in a simple format like "INV-0001", "INV-0002", etc.
        return 'INV-' . str_pad($newInvoiceNumber, 4, '0', STR_PAD_LEFT);
    }

    public function carts($product_id)
    {
        return Cart::query()->with('product')->where('product_id', $product_id)->first();
    }

    public function storePurchaseProduct($purchaseOrder, array $products){

        $storedProducts = [];

        foreach($products as $product){
            $addToCartProduct = $this->carts($product);
           // dd($addToCartProduct);
            if($addToCartProduct){
                $storedProduct =  PurchaseProduct::create([
                    'purchase_id'   => $purchaseOrder->id,
                    'product_id'    => $product,
                    'unit_price'    => $addToCartProduct->unit_price,
                    'quantity'      => $addToCartProduct->quantity,
                    'sub_total'     => $addToCartProduct->unit_price * $addToCartProduct->quantity,
                    'brand_id'      => $addToCartProduct->product->brand_id,
                    'origin_id'     => $addToCartProduct->product->origin_id,
                    'unit_id'       => $addToCartProduct->product->unit_id,
                ]);

                $storedProducts[] = $storedProduct;
            }
        }
        return $storedProducts;

    }

    public function productExistInProductStock($product_id){
       return ProductStock::query()->where('product_id', $product_id)->first();
    }



    public function productStock($storePurchase, array $products){

        $productStock = [];
        foreach($products as $product){

            $productExistInCart             = $this->carts($product);
            $productExistIn_ProductStock    = $this->productExistInProductStock($product);

            if($productExistIn_ProductStock){

                $stockInQuantity            = intval($productExistIn_ProductStock->all_time_stock_in) +  intval($productExistInCart->quantity);
                $availableQuantity          = $stockInQuantity - intval($productExistIn_ProductStock->all_time_stock_out);

                $productExistIn_ProductStock::query()->update([
                    'all_time_stock_in'     => $stockInQuantity,
                    'available_quantity'    => $availableQuantity,
                ]);

                $productStock[] = $productExistIn_ProductStock;

            }else{
                    $allTimeStockIn         =  intval($productExistInCart->quantity);  // $addToCartProduct->quantity
                    $allTimeStockOut        = 0;
                    $availableQuantity      = $allTimeStockIn - $allTimeStockOut;

                    $storeProductStock      = ProductStock::query()->create([
                            'product_id'    => $product,
                            'brand_id'      => $productExistInCart->product->brand_id,
                            'origin_id'     => $productExistInCart->product->origin_id,
                            'unit_id'       => $productExistInCart->product->unit_id,
                        'all_time_stock_in' => $allTimeStockIn,
                        'all_time_stock_out' => $allTimeStockOut,
                        'available_quantity' => $availableQuantity
                    ]);

                    $productStock[] = $storeProductStock;

            }
        }
        return $productStock;
    }

    public function deleteCartsItems($carts){

        foreach($carts as $cart){
            $cart = Cart::query()->find($cart);
            if($cart){
                $cart->delete();
            }
        }
    }


    public function getTransactionHistory($id){
       return  Transaction::query()->where('id', $id)->with('purchase')->get();
    }

    public function findPurchase($purchaseId){
        return Purchase::query()->where('id', $purchaseId)->first();
    }

    public function showCustomerDetails($purchaseId){
        return Purchase::query()->where('id', $purchaseId)->with('customer')->first();
    }


    public function getPurchaseTransactions($transactionId){
        return Transaction::query()->with([
            'purchase.purchase_product.product',
            'purchase.supplier',
            'purchase.customer',
            'userAdmin'
        ])->where('trx_id', $transactionId)->first();
    }

}
