@extends('layouts.main_page')

@section('css')

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

<!-- BEGIN: Content-->

    <div class="content-wrapper container-xxl p-0">
      
        <div class="content-body">

            @if(Auth::guard('teachers')->user()->parent == 0)
            <!-- Statistics card section -->
            <section id="statistics-card">
                <!-- Miscellaneous Charts -->
                <div class="row match-height">
                    <!-- Bar Chart -Orders -->
                   
                    <!--/ Line Chart -->
                    <div class="col-lg-12 col-12">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <h4 class="card-title">احصائيات المستخدمين</h4>
                                <div class="d-flex align-items-center">
                                    <p class="card-text me-25 mb-0"> تم تحديثه اليوم </p>
                                </div>
                            </div>
                            <div class="card-body statistics-body" style="background:#dedcff7a">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
                                        <div class="d-flex flex-row">
                                            <div class="avatar bg-light-primary me-2">
                                                <div class="avatar-content">
                                                    <i data-feather="activity" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <?php $user_course =\App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->pluck('id'); ?>
                                                <?php $user_mirmaz =\App\Models\User::where('mobile','009647703391199')->first(); ?>
                                                @if($user_mirmaz)
                                                     <?php 
                                                            $user_id =\App\Models\UserCourse::whereIn('course_id',$user_course)->where('user_id','!=',$user_mirmaz->id)->pluck('user_id');
                                                            $user =\App\Models\User::whereIn('id',$user_id)->count();
                                                     
                                                     ?>
                                                @else
                                                
                                                     <?php
                                                            $user_id =\App\Models\UserCourse::whereIn('course_id',$user_course)->pluck('user_id');
                                                            $user =\App\Models\User::whereIn('id',$user_id)->count();
                                                         ?>
                                                @endif
                                                <h4 class="fw-bolder mb-0">{{ $user }}</h4>
                                                <p class="card-text font-small-3 mb-0"> الطلاب المشتركين</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
                                        <div class="d-flex flex-row">
                                            <div class="avatar bg-light-info me-2">
                                                <div class="avatar-content">
                                                    <i data-feather="user" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <?php $user =\App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->count(); ?>
                                                <h4 class="fw-bolder mb-0">{{ $user }}</h4>
                                                <p class="card-text font-small-3 mb-0"> عدد الدورات</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                        <div class="d-flex flex-row">
                                            <div class="avatar bg-light-danger me-2">
                                                <div class="avatar-content">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <?php $course_id =\App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->pluck('id'); ?>
                                                <?php $user =\App\Models\Section::whereIn('course_id',$course_id)->count(); ?>
                                                <h4 class="fw-bolder mb-0">{{ $user }}</h4>
                                                <p class="card-text font-small-3 mb-0"> عدد الاقسام</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="d-flex flex-row">
                                            <div class="avatar bg-light-success me-2">
                                                <div class="avatar-content">
                                                    <i class="fa-solid fa-ban"></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <?php $course_idd =\App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->pluck('id'); ?>
                                                <?php $course_d =\App\Models\Section::whereIn('course_id',$course_idd)->pluck('id'); ?>
                                                <?php $user =\App\Models\Lesson::whereIn('section_id',$course_d)->where('link','!=',null)->count(); ?>
                                                <h4 class="fw-bolder mb-0">{{ $user }}</h4>
                                                <p class="card-text font-small-3 mb-0">عدد الدروس</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Miscellaneous Charts -->

                <!-- Stats Vertical Card -->
                <div class="row">
                  

                    <div class="col-xl-6 col-md-6 col-sm-6">
                        <canvas id="myChart2"></canvas>
                    </div>
                    

                </div> <br> <br>


     
            </section>

            @endif
            <!--/ Statistics Card section-->


       

     

@endsection


@section('js')
  

    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = [
          'January',
          'February',
          'March',
          'April',
          'May',
          'June',
          'July',
          'August',
          'September',
          'October',
          'November',
          'December',
        ];
      
        const data = {
          labels: labels,
          datasets: [{
            label: 'المستخدمين',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [  {{ $data["month1"] }}, {{ $data["month2"] }}, {{ $data["month3"] }},
                {{ $data["month4"] }}, {{ $data["month5"] }}, {{ $data["month6"] }}, {{ $data["month7"] }},
                {{ $data["month8"] }},{{ $data["month9"] }},{{ $data["month10"] }},{{ $data["month11"] }},
                {{ $data["month12"] }} ],
          }]
        };
      
        const config = {
          type: 'line',
          data: data,
          options: {}
        };
  
        const myChart = new Chart(
        document.getElementById('myChart'),
        config
        );
    </script>



   
    <script>
        const labels2 = [
          'January',
          'February',
          'March',
          'April',
          'May',
          'June',
          'July',
          'August',
          'September',
          'October',
          'November',
          'December',
        ];
      
        const data2 = {
          labels: labels2,
          datasets: [{
            label: 'عدد المشتركين ',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [ {{ $data["usercourse1"] }}, {{ $data["usercourse2"] }}, {{ $data["usercourse3"] }},
                {{ $data["usercourse4"] }}, {{ $data["usercourse5"] }}, {{ $data["usercourse6"] }}, {{ $data["usercourse7"] }},
                {{ $data["usercourse8"] }},{{ $data["usercourse9"] }},{{ $data["usercourse10"] }},{{ $data["usercourse11"] }},
                {{ $data["usercourse12"] }} ],
          }]
        };
      
        const config2 = {
          type: 'bar',
          data: data2,
          options: {}
        };

        const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
        );
  </script>
   
      



@endsection