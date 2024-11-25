<?php

namespace App\Services\DuesPurchase;

use App\Models\Purchase;
use App\Services\Transaction\TransactionService;

class DuesPurchaseService{

    public function getDuesPurchase(
        $paginatePluckOrGet = null,
        $payment_status = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null
    )
    {
        $query = Purchase::query();

        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if (!is_null($payment_status)) {
            $query->where('payment_status',$payment_status);
        }
        if (is_null($paginatePluckOrGet)) {
            return $query->pluck('id', 'name');
        }
        return $paginatePluckOrGet ? $query->paginate(20) : $query->get();
    }

    public function purchaseAccordingToInvoice($invoice_no){
        return Purchase::query()->where('invoice_no',$invoice_no )->first();
    }

    public function getById($id){
        return Purchase::query()->where('id',$id )->first();
    }
    public function updatePayPurchase($id,$data){
        $purchase =  $this->getById($id);

        if (!$purchase) {
            throw new \Exception("Purchase not found ");
        }

        $data['paid_amount']    = $purchase['paid_amount'] + $data['paid_amount'];
        $data['due_amount']     = $purchase['grand_total'] - $data['paid_amount'] ;

//        if($data['paid_amount'] >= $purchase['grand_total']){
//            $data['payment_status'] = 1;
//        }

        $data['payment_status'] = $data['paid_amount'] >= $purchase['grand_total'] ? 1 : 0;

        $data['updated_at'] = now();

        $updatePurchase =  $purchase->update($data);

        return [$updatePurchase,$purchase];
    }

    public function storeTransaction($updatePurchase, $paid_amount){
       //  dd($updatePurchase);
        $data['purchase_id'] = $updatePurchase->id;
        $data['amount'] = $paid_amount;
        $dueAmount = $updatePurchase->grand_total - $updatePurchase->paid_amount;
        $data['note'] = "Purchase Due amount is : $dueAmount";
        $data['customer_id'] = $updatePurchase->supplier_id;

        return (new TransactionService())->transactionInsertOrUpdate($data);
    }


}
