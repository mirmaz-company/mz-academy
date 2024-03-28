

        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user"

                data-id=             "{{ $data->id }}"
                data-discount=       "{{ $data->discount }}"
                data-number=         "{{ $data->number }}"
      
   

        > <i class="fa fa-edit"></i> </a>
   
  
                
        <a class="btn btn-sm btn-success" href="{{ route('export_coupon',$data->id) }}"
           
        ><i class="fa fa-download"></i></a>


        <a class="btn btn-sm btn-danger" data-toggle="modal" href="#show_user"

          <?php $coupons = \App\Models\CouponCode::where('coupon_id',$data->id)->get(); ?>

           data-showw="@foreach ($coupons as $key => $coupon) <h1> #{{ $key + 1 }}</h1>{{$coupon->name}} <br> @endforeach"
        ><i class=""></i>عرض</a>
        
        
        <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
           data-id=             "{{ $data->id }}"
        ><i class="fa fa-trash"></i></a>




