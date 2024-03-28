<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasesCardPrice extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'purchases_card_price';
}
