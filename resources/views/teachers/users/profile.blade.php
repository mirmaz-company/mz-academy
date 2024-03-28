@extends('layouts.main_page')

@section('css')


    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">

@endsection


@section('content')

<div class="row">
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="app-user-view">
                <!-- User Card & Plan Starts -->
                <div class="row">
                    <!-- User Card starts-->
                    <div class="col-xl-12 col-lg-12 col-md-7">
                        <div class="card user-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                                        <div class="user-avatar-section">
                                            <div class="d-flex justify-content-start">
                                                @if($user->image != null)
                                                <img class="img-fluid rounded" src="{{ $user->image }}" height="104" width="104" alt="User avatar" />
                                                @else
                                                <img class="img-fluid rounded" src="{{ asset('Asset 1.png') }}" height="104" width="104" alt="User avatar" />
                                                @endif
                                                <div class="d-flex flex-column ml-1">
                                                    <div class="user-info mb-1">
                                                        <h4 class="mb-0">{{ $user->name ?? "-" }}</h4>
                                                        <span class="card-text">{{ $user->mobile ?? "-" }} </span>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="d-flex align-items-center user-total-numbers">
                                            <div class="d-flex align-items-center mr-2">
                                                <div class="color-box bg-light-primary">
                                                    <i data-feather="dollar-sign" class="text-primary"></i>
                                                </div>
                                                <div class="ml-1">
                                                    <h5 class="mb-0"><?php $course_cont = \App\Models\UserCourse::where('user_id',$user->id)->count(); ?> {{ $course_cont }}</h5>
                                                    <small>الكورسات المشترك فيها </small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="color-box bg-light-success">
                                                    <i data-feather="trending-up" class="text-success"></i>
                                                </div>
                                                <div class="ml-1">
                                                    <h5 class="mb-0"><?php $course_cont = \App\Models\UserCourse::where('user_id',$user->id)->count(); ?> {{ $course_cont }}</h5>
                                                    <small>الكورسات المشترك فيها </small>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                                        <div class="user-info-wrapper">
                                            <div class="d-flex flex-wrap">
                                                <div class="user-info-title">
                                                    <i data-feather="user" class="mr-1"></i>
                                                    <span class="card-text user-info-title font-weight-bold mb-0">{{ $user->id ?? "-" }}</span>
                                                </div>
                                                <p class="card-text mb-0"></p>
                                            </div>
                                            <div class="d-flex flex-wrap my-50">
                                                <div class="user-info-title">
                                                    <i data-feather="check" class="mr-1"></i>
                                                    <span class="card-text user-info-title font-weight-bold mb-0">
                                                        <?php if($user->status == 0){
                                                                 $m = "غير مفعل";
                                                              }elseif($user->status == 1){
                                                                $m = "مفعل";
                                                              }else{
                                                                $m = "رفض";
                                                              }
                                                         ?>
                                                    </span>
                                                    {{ $m }}
                                                </div>
                                                <p class="card-text mb-0"></p>
                                            </div>
                                            <div class="d-flex flex-wrap my-50">
                                                <div class="user-info-title">
                                                    <i data-feather="star" class="mr-1"></i>
                                                    <span class="card-text user-info-title font-weight-bold mb-0">طالب</span>
                                                </div>
                                                <p class="card-text mb-0"></p>
                                            </div>
                                            <div class="d-flex flex-wrap my-50">
                                                <div class="user-info-title">
                                                    <i data-feather="flag" class="mr-1"></i>
                                                    <span class="card-text user-info-title font-weight-bold mb-0">العراق</span>
                                                </div>
                                                <p class="card-text mb-0"></p>
                                            </div>
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /User Card Ends-->

                    <!-- Plan Card starts-->
                    {{-- <div class="col-xl-3 col-lg-4 col-md-5">
                        <div class="card plan-card border-primary">
                            <div class="card-header d-flex justify-content-between align-items-center pt-75 pb-1">
                                <h5 class="mb-0">المحفظة </h5>
                                <span class="badge badge-light-secondary" data-toggle="tooltip" data-placement="top" title="Expiry Date">July 22, <span class="nextYear"></span>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="badge badge-light-primary">Basic</div>
                                <ul class="list-unstyled my-1">
                                    <li>
                                        <span class="align-middle">5 Users</span>
                                    </li>
                                    <li class="my-25">
                                        <span class="align-middle">10 GB storage</span>
                                    </li>
                                    <li>
                                        <span class="align-middle">Basic Support</span>
                                    </li>
                                </ul>
                                <button class="btn btn-primary text-center btn-block">Upgrade Plan</button>
                            </div>
                        </div>
                    </div> --}}
                    <!-- /Plan CardEnds -->
                </div>
                <!-- User Card & Plan Ends -->

                <h1> مشاهدات الدروس</h1>
       
                <div class="row" id="table-striped-white">
                    <div class="col-12">
                        <div class="card">
                           
                            <div class="table-responsive">
                                <table class="table table-striped table-white">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th > اسم الدرس</th>
                                            <th >  الدورة</th>
                                            <th >  مستوى التقدم</th>
                                            <th >  التاريخ</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                            if(Auth::guard('teachers')->user()->parent == 0){
                                                $courses_ids = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->pluck('id');
                                            }else{
                                                $courses_ids = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->parent)->pluck('id');
                                            }
                                            
                                             
                                             ?>
                                        <?php $data_coruse = \App\Models\DataCourse::where('user_id', $user->id)->whereIn('course_id',$courses_ids)->where('progress','!=',0)->orderBy('updated_at','desc')->get(); ?>

                                        @if($data_coruse->count() > 0)
                                            @forelse ($data_coruse as $key=>$course)
                                                <?php $lesson = \App\Models\Lesson::where('id', $course->lesson_id)->first(); ?>
                                                <?php $course_name = \App\Models\Course::where('id', $course->course_id)->first(); ?>
                                    
                                            
                                                <tr>
                                                    <th scope="row">{{ $key + 1 }}</th>
                                                    @if($lesson)
                                                        <td>{{ $lesson->name ?? '' }}</td>
                                                    @else
                                                        <td>-</td>
                                                    @endif

                                                    @if($course_name)
                                                        <td>{{ $course_name->name ?? '' }}</td>
                                                    @else
                                                        <td>-</td>
                                                    @endif
                                                
                                                    <td> {{ $course->progress }} %</td>
                                                
                                                    <td>{{ $course->updated_at ?? '' }}</td>
                                                
                                                </tr>
                                                @empty
                                                <tr>
                                                    <th style="text-align: center">لا يوجد </th>
                                                </tr>
                                            @endforelse
                                        @else
                                            <th style="text-align: center">لا يوجد </th>

                                        @endif
                                 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <h1>  درجات الطالب في الاختبار</h1>
       
                <div class="row" id="table-striped-white">
                    <div class="col-12">
                        <div class="card">
                           
                            <div class="table-responsive">
                                <table class="table table-striped table-white">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th > اسم الاختبار</th>
                                            <th >  الدرجة</th>
                                            <th >  التاريخ</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php    if(Auth::guard('teachers')->user()->parent == 0){
                                                   $courses_ids = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->pluck('id');
                                                }else{
                                                    $courses_ids = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->parent)->pluck('id');
                                                }
                                         ?>
                                        <?php $quizes = \App\Models\QuizStart::where('user_id', $user->id)->where('end_points','>',0)->whereIn('course_id',$courses_ids)->orderBy('updated_at','desc')->get(); ?>

                                        @forelse ($quizes as $key=>$quiz)
                                            <?php $quiz_name = \App\Models\Quiz::where('id', $quiz->quiz_id)->first(); ?>
                                   
                                         
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                @if($quiz_name)
                                                     <td>{{ $quiz_name->name ?? '' }}</td>
                                                @else
                                                      <td>-</td>
                                                @endif

                                            
                                                <td> {{ $quiz->end_points ?? '' }} / {{ $quiz_name->points  ?? ""  }} </td>
                                            
                                                <td>{{ $course->updated_at ?? '-' }}</td>
                                            
                                            </tr>
                                            @empty
                                            <tr>
                                                <th style="text-align: center">لا يوجد </th>
                                            </tr>
                                        @endforelse
                                 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



            

         
            </section>

        </div>
    </div>
</div>
<!-- END: Content-->

</div>



@endsection