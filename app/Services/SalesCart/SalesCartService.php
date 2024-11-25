<?php
    namespace App\Services\SalesCart;

    use App\Models\Cart;
    use App\Models\SalesCart;

    class SalesCartService{

        public function getSalesCarts(
            $paginatePluckOrGet = null,
            $onlyActive = null,
            $onlyParents = null,
            array $relationships = [],
            array $options = [],
            $id = null)
        {
            $query = SalesCart::query();

            !empty($relationships) ? $query->with($relationships) : $query->with([]);

            if(!is_null($onlyActive)){
                $query->where('status', $onlyActive);
            }
            if(is_null($paginatePluckOrGet)){
                return $query->pluck('id','name');
            }
            return $paginatePluckOrGet ? $query->paginate(10) : $query->get();
        }



        public function getSalesCartByProductId($id) {
            return SalesCart::query()->where('product_id', $id)->latest()->first();
        }

        public function storeSalesCart(array $payload){
            $payload['sub_total'] = $payload['unit_price'] * $payload['quantity'];
            return SalesCart::query()->create($payload);
        }

        public function getSalesCartById($id)  {
            return SalesCart::query()->find($id);
        }

        public function updateSalesCart($id, array $payload) {
            $salesCart = $this->getSalesCartByProductId($id);
            $payload['sub_total'] = $payload['unit_price'] * $payload['quantity'];
            return $salesCart->update($payload);
        }

        public function deleteSalesCart($id){
            $salesCart = $this->getSalesCartById($id);
            return $salesCart->delete();
        }


    }
