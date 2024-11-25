<?php

namespace App\Services\Transaction;

use App\Models\Transaction;
use Illuminate\Support\Str;

class TransactionService{

    public function transactionInsertOrUpdate(array $payload ){

            $payload['trx_id'] = $this->uniqueTransactionId();
            return Transaction::query()->create($payload);
    }

    private static function uniqueTransactionId()
    {
        return 'TRX' . time() . Str::upper(Str::random(5));
    }
}
