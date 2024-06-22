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
        <li class="breadcrumb-item"><a href="#">الصفحة الشخصية</a>
        </li>
    </ol>
</div> <br>

        <div class="row">
            <div class="col-md-4">
           
                <div class="card card-profile">
                        <img src="../../../app-assets/images/banner/banner-12.jpg" class="img-fluid card-img-top" alt="Profile Cover Photo" />
                        <div class="card-body">
                            <div class="profile-image-wrapper">
                                <div class="profile-image">
                                    <div class="avatar">
                                        <img src="{{ $user->photo ?? ""}}" alt="Profile Picture" />
                                    </div>
                                </div>
                            </div>
                            <h3>{{ $user->name ??"" }}</h3>
                            <h6 class="text-muted">{{ $user->type ==  NULL ?"User" : "Vendor" }}</h6>
                            <div class="badge badge-light-primary profile-badge">new</div>
                            <hr class="mb-2" />
                            <div class="row">
                                <div class="col-md-4">الايميل :</div>
                                <div class="col-md-8">{{ $user->email ?? "" }}</div>
                                <div class="col-md-4"> الجوال : </div>
                                <div class="col-md-8">{{ $user->mobile ?? ""}}</div>
                                <div class="col-md-4">تفعيل الجوال :</div>
                                <div class="col-md-8">{{ $user->active_mobile == 0 ? "Not active" : 'active' }}</div>
                            </div>
                         
                            <hr class="mb-2" />
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted font-weight-bolder">التقييم</h6>
                                    <h3 class="mb-0">{{ $user->rate ?? "" }}</h3>
                                </div>
                                <div>
                                    <h6 class="text-muted font-weight-bolder">القسم</h6>
                                    <?php $category = \App\Models\Category::where('id',$user->category_id)->pluck('title')->first();?>
                                    <h3 class="mb-0">{{ $category ?? "" }}</h3>
                                </div>
                                <div>
                                    <h6 class="text-muted font-weight-bolder">الحالة</h6>
                                    <h3 class="mb-0">{{ $user->available == "0"? "متاح" :  "غير متاح"}}</h3>
                                </div>
                            </div>
                        </div>
                   
                </div>

            </div>


            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">السفن التي يملكها</h4>
                    </div>
                    @forelse($ships_users as $ships_user)
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="card-text">{{ $ships_user->title }}</p>
                                    <p class="card-text">
                                        {{ $ships_user->description ?? ""}}
                                    </p>
                                </div>
                                <div class="col-md-8">
                                    <img src="{{ $ships_user->image }}" style="height: 50%;width:50%" class="img-thumbnail" alt="">
                                </div>
                            </div>
                        
                            {{-- <hr />
                            <p class="card-text">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                dolore magna aliqua.
                            </p> --}}
                        </div>
                    @empty
                        <h5>لا يمتلك سفن</h5>
                    @endforelse
                </div>
            </div>
        </div>
     
    




@endsection