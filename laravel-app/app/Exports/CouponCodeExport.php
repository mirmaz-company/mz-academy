<?php

namespace App\Exports;

use App\Models\CouponCode;
use Maatwebsite\Excel\Concerns\FromCollection;

class CouponCodeExport implements FromCollection
{

    private $branch;

    public function set_id_copoun($id)
    {
        $this->id = $id;
        
    }
  
    public function collection()
    {
        return CouponCode::where('coupon_id',$this->id)->get(['name']);
    }
}
