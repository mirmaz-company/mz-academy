@extends('layouts.main_page')

@section('css')
]
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">

@endsection


@section('content')

       
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">    {{ trans('main_trans.main_page') }}</a>
        </li>
        <li class="breadcrumb-item"><a href="#">الاحصائيات</a>
        </li>
    </ol>
</div>


<div class="row match-height">

 
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-center pb-0">
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">{{ \App\Models\User::count() }}</h2>
                <p class="card-text">المستخدمين</p>
            </div>
            <div id="order-chart"></div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-center pb-0">
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">{{ \App\Models\Support::count() }}</h2>
                <p class="card-text"> عدد رسائل الدعم </p>
            </div>
            <div id="order-chart"></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-center pb-0">
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">{{ \App\Models\Product::count() }}</h2>
                <p class="card-text">   المنتجات </p>
            </div>
            <div id="order-chart"></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">

    </div>

   
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-center pb-0">
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">{{ \App\Models\Order::count() }}</h2>
                <p class="card-text">   عدد الطلبات الكلي </p>
            </div>
            <div id="order-chart"></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-center pb-0">
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">{{ $order_today }}</h2>
                <p class="card-text">   عدد الطلبات اليومي </p>
            </div>
            <div id="order-chart"></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-center pb-0">
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">{{ $order_month }}</h2>
                <p class="card-text">   عدد الطلبات الشهري </p>
            </div>
            <div id="order-chart"></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
     
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-center pb-0">
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">{{ $order_price }}</h2>
                <p class="card-text">  اجمالي السعر  </p>
            </div>
            <div id="order-chart"></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-center pb-0">
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">{{ $order_price_today }}</h2>
                <p class="card-text"> اجمالي السعر اليومي </p>
            </div>
            <div id="order-chart"></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-center pb-0">
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">{{ $order_price_month }}</h2>
                <p class="card-text"> اجمالي السعر الشهري </p>
            </div>
            <div id="order-chart"></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
     
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-center pb-0">
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">{{ $five_price }}</h2>
                <p class="card-text"> <h3>(5%)</h3>اجمالي السعر  </p>
            </div>
            <div id="order-chart"></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-center pb-0">
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">{{ $five_price_today }}</h2>
                <p class="card-text"> <h3>(5%)</h3> اجمالي السعر اليومي  </p>
            </div>
            <div id="order-chart"></div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-center pb-0">
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">{{ $five_price_month }}</h2>
                <p class="card-text"> <h3>(5%)</h3>  اجمالي السعر الشهري  </p>
            </div>
            <div id="order-chart"></div>
        </div>
    </div>
   


 
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">اكثر المنتجات مبيعا </h4>
                <div class="heading-elements">
                   
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>المنتج</th>
                                           <th style="width:100px">الصورة</th>
                                            <th>كم مرة تم بيعه</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($top_product_seller as $key => $top_product_sellerr)
                                            <?php $product = \App\Models\Product::where('id',$top_product_sellerr->product_id)->first();  ?>
                                            <?php $product_count_seller = \App\Models\Cart::where('product_id',$top_product_sellerr->product_id)->count();  ?>


                                            <tr>
                                                <td>{{  $key + 1 }}</td>
                                                <td class="text-center">
                                                    {{ $product->name ?? "-" }}
                                                </td>
                                                <td style="width: 25%"><img src="{{ $product->image  ?? "-"  }}" style="width: 50%" alt=""></td>
                                                <td><h3>{{ $product_count_seller  ?? "-"  }}</h3></td>
                                            </tr>
                                        @endforeach
                                       
                                     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


       

     

@endsection


@section('js')
  

    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>

    {{-- <script src="{{asset('app-assets/js/scripts/pages/dashboard-analytics.js')}}"></script> --}}
@endsection