<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VpnCheck extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'vpn_check';
}
