<?php
    namespace App\Services\Home;

    use App\Models\Category;
    use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\User;

class HomeService{

        public function getCount(){
            return [
                'totalCategories'   => Category::totalCategory(),
                'totalProducts'     => Product::totalProduct(),
                'totalPurchases'    => Purchase::totalPurchase(),
                'totalSales'        => Sale::totalSale(),
                'totalAdmins'       => User::totalAdmin(),
                'totalCustomers'    => User::totalCustomer(),
                'totalSuppliers'    => User::totalSupplier(),
                'purchaseDues'      => Purchase::duesPurchase(),
                'saleDues'          => Sale::duesSale(),
                'todayTotalPurchase'=> $this->purchaseInfo('todayTotalPurchase'),
                'todayTotalSell'    =>  $this->salesInfo('todayTotalSell'),
                'allTimePurchase'   => $this->purchaseInfo('allTimePurchase'),
                'allTimeSales'       => $this->salesInfo('allTimeSales'),
                'supplierTotalDues' => $this->purchaseInfo('supplierTotalDues'),
                'customerTotalDues' =>  $this->salesInfo('customerTotalDues'),

               'topSellingProduct'  => $this->salesInfo('topSellingProduct'),
                'topPurchaseProduct'=> $this->purchaseInfo('topPurchaseProduct'),
                  'test'        => $this->purchaseInfo('test'),
            ];
        }

        private function totalAmount($value) {
            $totalAmount = 0;
            foreach ($value as $item){
                $totalAmount += $item['grand_total'] ;
            }
            return $totalAmount;
        }

        private function duesAmount($value) {
            $totalAmount = 0;
            foreach ($value as $item){
                $totalAmount += $item['due_amount'] ;
            }
            return $totalAmount;
        }

        private function purchaseInfo($queryString){

            $query = Purchase::query();

            if($queryString == "todayTotalPurchase"){
                $value = $query->whereDate('created_at', now())->get();
                return $this->totalAmount($value);
            }

            if($queryString == "allTimePurchase" ){
                $value = $query->get();
                return $this->totalAmount($value);
            }

            if($queryString == "supplierTotalDues"){
                $value = $query->whereDate('created_at', now())->get();
                return $this->duesAmount($value);
            }




            if($queryString == "topPurchaseProduct"){
                $value = $query->with('purchase_product')->get();
               // dd($value);
                $products =[];
                foreach($value as $item){
                  //  dd($item);
                    if($item['purchase_product']){

                       //' dd($item['purchase_product']);
                        foreach($item['purchase_product'] as $product){

                           // dd($item['purchase_product'], $product);
                            if(!array_key_exists($product['product_id'], $products)){
                               // dd( $products);
                                $products[$product['product_id']] = $product['quantity'];
                            }else{
                                $products[$product['product_id']] += $product['quantity'];
                              //  dd($products, $products[$product['product_id']]);
                            }

                        }
                    //   dd( $products);
                    }
                }
               //  dd($products);
                if(!empty($products)){
                    $topProductId = '';
                    $topQuantity = 0;
                    foreach($products as $productId => $quantity){
                        if( $quantity > $topQuantity){
                            $topQuantity    = $quantity;
                            $topProductId   = $productId;
                        }
                    }

                    $product = Product::query()->find($topProductId);
                    // dd($product, $topQuantity);
                    return ['product' => $product, 'quantity' => $topQuantity];
                }

            }

// Top supplier's total amount
//            if($queryString == "test"){
//                $value = $query->get();
//                $supplierIds = [];
//                foreach ($value as $item){
//                    if(!in_array($item['supplier_id'], $supplierIds )) {
//                        $supplierIds[$item['supplier_id']] = $item['paid_amount'];
//                    }else{
//                        $supplierIds[$item['supplier_id']] += $item['paid_amount'];
//                    }
//                }
//                if(!empty($supplierIds)){
//                    $topSupplierId = "";
//                    $topAmount = 0;
//                    foreach ($supplierIds as $supplierId => $amount){
//                        if($amount > $topAmount){
//                            $topAmount = $amount;
//                            $topSupplierId = $supplierId;
//                        }
//                    }
//                    $topSupplier = $query->where('supplier_id', $topSupplierId)->first();
//                    return [$topSupplier, $topAmount];
//                }
//            }



//            if($queryString == "topPurchaseProduct" ){
//                $value = $query->whereHas('purchase_product', function($query){
//                    $query->where( )
//                });
//
//
//
//
//                return $this->totalAmount($value);
//            }
        }

        private function salesInfo($queryString){
            $query = Sale::query();


            if($queryString == "todayTotalSell"){
                $value = $query->whereDate('created_at', now())->get();
                return $this->totalAmount($value);
            }

            if($queryString == "allTimeSales" ){
                $value = $query->get();
                return $this->totalAmount($value);
            }

            if($queryString == "customerTotalDues"){
                $value = $query->whereDate('created_at', now())->get();
                return $this->duesAmount($value);
            }


             if($queryString == "topSellingProduct"){
                 $value = $query->with('salesProducts')->get();
                 // dd($value);
                 $products =[];
                 foreach($value as $item){
                     //  dd($item);
                     if($item['salesProducts']){

                         //' dd($item['purchase_product']);
                         foreach($item['salesProducts'] as $product){

                             // dd($item['purchase_product'], $product);
                             if(!array_key_exists($product['product_id'], $products)){
                                 // dd( $products);
                                 $products[$product['product_id']] = $product['quantity'];
                             }else{
                                 $products[$product['product_id']] += $product['quantity'];
                                 //  dd($products, $products[$product['product_id']]);
                             }

                         }
                         //   dd( $products);
                     }
                 }
                 //  dd($products);
                 if(!empty($products)){
                     $topProductId = '';
                     $topQuantity = 0;
                     foreach($products as $productId => $quantity){
                         if( $quantity > $topQuantity){
                             $topQuantity    = $quantity;
                             $topProductId   = $productId;
                         }
                     }

                     $product = Product::query()->find($topProductId);
                    //  dd($product, $topQuantity);
                     return ['product' => $product, 'quantity' => $topQuantity];
                 }

             }

        }





    }

?>
