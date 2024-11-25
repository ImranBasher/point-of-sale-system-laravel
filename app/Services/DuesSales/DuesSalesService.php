<?php

namespace App\Services\DuesSales;
use App\Models\Sale;
use App\Services\Transaction\TransactionService;

class DuesSalesService{


    public function getDuesSales(
        $paginatePluckOrGet = null,
        $payment_status = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null
    )
    {
        $query = Sale::query();

        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if (!is_null($payment_status)) {
            $query->where('payment_status',$payment_status);
        }
        if (is_null($paginatePluckOrGet)) {
            return $query->pluck('id', 'name');
        }
        return $paginatePluckOrGet ? $query->paginate(20) : $query->get();
    }

    public function salesAccordingToInvoice($invoice_no){
        return Sale::query()->where('invoice_no',$invoice_no )->first();
    }

    public function getById($id){
        return Sale::query()->where('id',$id )->first();
    }

    public function updatePaySale($id,$data){
        $sale = $this->getById($id);

        if (!$sale) {
            throw new \Exception("Sale not found");
        }

        $data['paid_amount']    = $sale['paid_amount'] + $data['paid_amount'];
        $data['due_amount']     = $sale['grand_total'] - $data['paid_amount'] ;

        if($data['paid_amount'] >= $sale['grand_total']){
            $data['payment_status'] = 1;
        }
        $data['updated_at']     = now();

        $updateSale = $sale->update($data);

        return [$updateSale,$sale];
    }

    public function storeTransaction($updateSale, $paid_amount){
       //  dd($updateSale);
        $data['sale_id']    = $updateSale->id;
        $data['amount']     =  $paid_amount;
        $dueAmount          = $updateSale->grand_total - $updateSale->paid_amount;
        $data['note']       = "Sales Due amount is : $dueAmount";
        $data['customer_id'] = $updateSale->salesman_id ;

        return (new TransactionService())->transactionInsertOrUpdate($data);
    }



}
