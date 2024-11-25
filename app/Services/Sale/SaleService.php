<?php

namespace App\Services\Sale;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SalesCart;
use App\Models\SalesProduct;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Transaction\TransactionService;

class SaleService{
    public function getProducts(
        $paginatePluckOrGet = null,
        $onlyActive = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null)
    {
        $query = Product::query();

        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if(!is_null($onlyActive)){
            $query->where('status', $onlyActive);
        }
        if(is_null($paginatePluckOrGet)){
            return $query->pluck('id','name');
        }
        return $paginatePluckOrGet ? $query->paginate(10) : $query->get();
    }

    public function getAllSales(
        $paginatePluckOrGet = null,
        $onlyActive = null,
        $onlyDues = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null)
    {
        $query = Sale::query();

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

    public function getAllProducts(){
        return Product::query()->where('status','1')->get();
    }

    public function getAllCustomers(){
        return User::query()->where('role','0')->get();
    }




    /// Filtering
    public function getFilteredSales(array $payload){

        //  dd($payload);
        $customerId     = $payload['customer_id'];
        $productId      = $payload['product_id'];
        $startDate      = $payload['start_date'];
        $endDate        = $payload['end_date'];

        $sales = Sale::query();

        if (!is_null($customerId)) {
            $sales->where('customer_id',  strval($customerId));
        }

        if(!empty($productId)) {
            $sales->whereHas('salesProducts', function($query) use ($productId) {
                $query->where('product_id', $productId);
            });
        }

        if(!empty($startDate && $endDate)) {
            $sales->whereBetween('created_at', [$startDate, $endDate]);
        }
        return $sales->get();
    }

    public function salesCart($product_id)
    {
        return SalesCart::query()->with('product')->where('product_id', $product_id)->first();
    }
    private function generateInvoiceNumber()
    {
        $latestSale = Sale::latest('id')->first();
        // If there is no purchase yet, start from 1
        $newInvoiceNumber = $latestSale ? $latestSale->id + 1 : 1;
        // Return the invoice number in a simple format like "INV-0001", "INV-0002", etc.
        return 'INV-' . str_pad($newInvoiceNumber, 4, '0', STR_PAD_LEFT);
    }

    public function storeSales(array $payload)
    {
        $payload['invoice_no'] = $this->generateInvoiceNumber();
        $payload['salesman_id'] = userId();
        $payload['due_amount'] = $payload['grand_total'] - $payload['paid_amount'];
        return Sale::query()->create($payload);
    }

    public function storeTransaction($sales){
        $data['sales_id'] = $sales->id;
        $data['amount'] = $sales->paid_amount;
        $dueAmount = $sales->grand_total - $sales->paid_amount;
        $data['note'] = "Your due amount is : $dueAmount";
        $data['customer_id'] = $sales->customer_id;

       return  (new TransactionService())->transactionInsertOrUpdate($data);

    }

    public function storeSalesProduct($salesOrder, $products){
        $storedProducts = [];
        foreach($products as $product){
            $addSalesCartProduct = $this->salesCart($product);

            if($addSalesCartProduct){
                $storeProduct = SalesProduct::query()->create([
                    'sales_id'      => $salesOrder->id,
                    'product_id'    => $product,
                    'unit_price'    => $addSalesCartProduct->unit_price,
                    'quantity'      => $addSalesCartProduct->quantity,
                    'sub_total'     => $addSalesCartProduct->unit_price * $addSalesCartProduct->quantity,
                    'brand_id'      => $addSalesCartProduct->product->brand_id,
                    'origin_id'     => $addSalesCartProduct->product->origin_id,
                    'unit_id'       => $addSalesCartProduct->product->unit_id,
                ]);
                $storedProducts[] = $storeProduct;
            }
        }
        return $storedProducts;
    }
    public function productExistInProductStock($product_id){{
        return ProductStock::query()->where('product_id', $product_id)->first();
    }}



    public function showSalesProductDetails($saleId){
        return SalesProduct::query()
            ->where('sales_id', $saleId)
            ->get();
    }

    public function showSalesTransection($saleId){
     //   dd($saleId);
        return Transaction::query()
            ->where('sales_id', $saleId)
            ->with('sales')
            ->get();

    }




    public function updateProductStock( array $products){
        $productStock = [];
        foreach($products as $product){
            $salesCartProductExist = $this->salesCart($product);

          //  dd($salesCartProductExist);
            $productExistIn_ProductStock = $this->productExistInProductStock($product);

            if($productExistIn_ProductStock){
                $nowStockOutQuantity = $productExistIn_ProductStock->all_time_stock_out + intval($salesCartProductExist->quantity) ; // Right
               // dd($nowStockOutQuantity);
                $availableQuantity = $productExistIn_ProductStock->all_time_stock_in - $nowStockOutQuantity ;

                $productExistIn_ProductStock::query()->update([
                    'all_time_stock_out' => $nowStockOutQuantity,
                    'available_quantity' => $availableQuantity,
                ]);
                $productStock[] = $productExistIn_ProductStock;
            }
        }
        return $productStock;
    }

    public function deleteSalesCartItems($salesCartIds){

        foreach($salesCartIds as $salesCartId){
            $salesCart = SalesCart::query()->find($salesCartId);
            if($salesCart){
                $salesCart->delete();
            }
        }
    }

    public function getTransactionHistory($transactionId){
       // dd($transactionId);
      return Transaction::query()->with([
            'sales.salesProducts.product',  // product info
            'sales.customer', // customer info
            'sales.salesman', // salesMan info
            'saleCustomer' // who paid bill as a customer
        ])->where('trx_id',$transactionId )->first();
    }

}
