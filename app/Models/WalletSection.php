<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletSection extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'wallet_code_sections';
}
