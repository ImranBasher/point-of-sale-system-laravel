<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getCarts(
        $paginatePluckOrGet = null,
        $onlyActive = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null)
    {
        $query = Cart::query();

        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if(!is_null($onlyActive)){
            $query->where('status', $onlyActive);
        }
        if(is_null($paginatePluckOrGet)){
            return $query->pluck('id','name');
        }
        return $paginatePluckOrGet ? $query->paginate(10) : $query->get();
    }

    public function getUsers()
    {
        return User::query()
            ->where('id', '!=', Auth::id())
            ->where('role', '!=', '1')
            ->get();
    }

    public function getCartById($id)
    {
        return Cart::query()->find($id);
    }

    public function getCartByProductId($id)
    {
        return Cart::query()->where('product_id', $id)->latest()->first();
    }

    public function storeCart(array $payload){
        $payload['sub_total'] = $payload['unit_price'] * $payload['quantity'];
        return Cart::query()->create($payload);
    }

    public function updateCart($id, array $payload){
        $cart = $this->getCartByProductId($id);
        $payload['sub_total'] = $payload['unit_price'] * $payload['quantity'];
       return $cart->update($payload);
    }
    public function deleteCart($id){
        $cart = $this->getCartById($id);
       return $cart->delete();
    }
}
