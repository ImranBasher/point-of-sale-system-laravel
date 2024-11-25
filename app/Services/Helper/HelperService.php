<?php

namespace App\Services\Helper;

use App\Models\User;

class HelperService{

    public function getUsers(){
        return User::query()
            ->where('id', '!=', auth()->id()) // or userId() if it's a custom function
            ->orWhere('role', '!=', '1')
            ->get();
    }
}
