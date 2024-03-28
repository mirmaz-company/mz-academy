<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // عرض الطلب مع المنتجات الخاصة فيه والكمية لكل طلب

    public function products(){
        return $this -> belongsToMany(Product::class,'order_product','order_id','product_id','id','id')
        ->withPivot(
            'quantity',
            );;

            // في الجدول الوسيط ما بيعرض الا الفورن كي ..اذا بدي اعرض الكمية كمان..بحط with pivot
     
    }
}
