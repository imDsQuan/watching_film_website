<?php

namespace App\Repositories;

use App\Models\Payments;

class PaymentRepository extends EloquentRepository
{

    public function getModel()
    {
        return Payments::class;
    }
}
