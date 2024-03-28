@extends('layouts.main_page')

@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css') }}">
@endsection


@section('content')


<button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button> 
<button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button> 
<button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 








    <div class="breadcrumb-wrapper">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"> {{ trans('main_trans.main_page') }} </a>
            </li>
            <li class="breadcrumb-item"><a href="#">الاعدادات</a>
            </li>
        </ol>
    </div>

    <form id="usersFormUpdate">
        @csrf
        <div class="row">
            <div class="form-group col-md-6">
                <label for="inputPassword4">اسم اللوحة </label>
                <input type="text" name="dashboardname"
                    value="{{ App\Models\Setting::all()->pluck('dashboardname')->last() }}" class="form-control"
                    id="inputPassword42" placeholder="NameDashboard">
                <span id="namedashboard" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4"> رقم الجوال </label>
                <input type="text" name="mobile"
                    value="{{ App\Models\Setting::all()->pluck('mobile')->last() }}" class="form-control">
                <span id="namedashboard" class="text-danger"></span>
            </div>

            <div class="form-group col-md-6">
                <label for="inputPassword4">الصورة</label>
                <?php $image = App\Models\Setting::all()
                    ->pluck('image')
                    ->last(); ?>
                <div class="media mb-2">
                    <img src="{{ $image }}" alt="users avatar" id="image"
                        class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                    <div class="media-body mt-50">
                        <div class="col-12 d-flex mt-1 px-0">
                            <label class="btn btn-primary mr-75 mb-0" for="change-picture">
                                <span class="d-none d-sm-block">Change</span>
                                <input class="form-control" type="file" id="change-picture" name="image" hidden required
                                    accept="image/png,.svg, image/jpeg, image/jpg" />
                                <span class="d-block d-sm-none">
                                    <i class="mr-0" data-feather="edit"></i>
                                </span>
                            </label>
                            <button class="btn btn-outline-secondary d-block d-sm-none">
                                <i class="mr-0" data-feather="trash-2"></i>
                            </button>
                        </div>
                    </div>
                    <span id="image_error" class="text-danger"></span>
                </div>
              </div>
           </div>
        </div>

         

            <h1>الخصوصية</h1>
         <div class="row">

          

            <div class="form-group col-md-6">
                <label for="inputPassword4">العنوان  </label>
                <input type="text"
                     name="title_privacy"
                     value="{{ App\Models\Setting::all()->pluck('title_privacy')->last() }}" class="form-control" >
                <span id="namedashboard" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4"> الوصف  </label>
              
                     <textarea name="description_privacy" id="" class="form-control" cols="4" rows="4">{{ App\Models\Setting::all()->pluck('description_privacy')->last() }}</textarea>
                <span id="namedashboard" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4"> الصورة  </label>
                <?php $image = App\Models\Setting::all()
                ->pluck('image_privacy')
                ->last(); ?>
            <div class="media mb-2">
                <img src="{{ $image }}" alt="users avatar" id="image2"
                    class="user-avatar2 users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                <div class="media-body mt-50">
                    <div class="col-12 d-flex mt-1 px-0">
                        <label class="btn btn-primary mr-75 mb-0" for="change-picture2">
                            <span class="d-none d-sm-block">Change</span>
                            <input class="form-control" type="file" id="change-picture2" name="image_privacy" hidden required
                                accept="image/png,.svg, image/jpeg, image/jpg" />
                            <span class="d-block d-sm-none">
                                <i class="mr-0" data-feather="edit"></i>
                            </span>
                        </label>
                        <button class="btn btn-outline-secondary d-block d-sm-none">
                            <i class="mr-0" data-feather="trash-2"></i>
                        </button>
                    </div>
                </div>
                <span id="image_error" class="text-danger"></span>
            </div>
            </div>
        </div> <br><br>

            <h2>الوصف</h2>
        <div class="row">
           
            <div class="form-group col-md-6">
                <label for="inputPassword4"> العنوان </label>
                <input type="text"
                     name="title_about_us"
                     value="{{ App\Models\Setting::all()->pluck('title_about_us')->last() }}" class="form-control" >
                <span id="namedashboard" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4"> الوصف </label>
                {{-- <input type="text"
                     name="description_about_us"
                     value="{{ App\Models\Setting::all()->pluck('description_about_us')->last() }}" class="form-control" > --}}

                     <textarea name="description_about_us" id="" class="form-control" cols="4" rows="4">{{ App\Models\Setting::all()->pluck('description_about_us')->last() }}</textarea>
                <span id="namedashboard" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4"> الصورة  </label>
                <?php $image = App\Models\Setting::all()
                ->pluck('image_about_us')
                ->last(); ?>
                <div class="media mb-2">
                    <img src="{{ $image }}" alt="users avatar" id="image3"
                        class="user-avatar3 users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                    <div class="media-body mt-50">
                        <div class="col-12 d-flex mt-1 px-0">
                            <label class="btn btn-primary mr-75 mb-0" for="change-picture3">
                                <span class="d-none d-sm-block">Change</span>
                                <input class="form-control" type="file" id="change-picture3" name="image_about_us" hidden required
                                    accept="image/png,.svg, image/jpeg, image/jpg" />
                                <span class="d-block d-sm-none">
                                    <i class="mr-0" data-feather="edit"></i>
                                </span>
                            </label>
                            <button class="btn btn-outline-secondary d-block d-sm-none">
                                <i class="mr-0" data-feather="trash-2"></i>
                            </button>
                        </div>
                    </div>
                    <span id="image_error" class="text-danger"></span>
                </div>
            </div>
        </div><br><br>


            <h1>سوشيال ميديا</h1>

         <div class="row">

            <div class="form-group col-md-6">
                <label for="inputPassword4"> انستا </label>
                <input type="text"
                     name="insta"
                     value="{{ App\Models\Setting::all()->pluck('insta')->last() }}" class="form-control" >
                <span id="namedashboard" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">فيس بوك </label>
                <input type="text"
                     name="face_book"
                     value="{{ App\Models\Setting::all()->pluck('face_book')->last() }}" class="form-control" >
                <span id="namedashboard" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4"> يوتيوب </label>
                <input type="text"
                     name="youtube"
                     value="{{ App\Models\Setting::all()->pluck('youtube')->last() }}" class="form-control" >
                <span id="namedashboard" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4"> الموقع </label>
                <input type="text"
                     name="website"
                     value="{{ App\Models\Setting::all()->pluck('website')->last() }}" class="form-control" >
                <span id="website" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4"> تيلغرام </label>
                <input type="text"
                     name="telegram"
                     value="{{ App\Models\Setting::all()->pluck('telegram')->last() }}" class="form-control" >
                <span id="telegram" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4"> واتس اب </label>
                <input type="text"
                     name="whatsapp"
                     value="{{ App\Models\Setting::all()->pluck('whatsapp')->last() }}" class="form-control" >
                <span id="whatsapp" class="text-danger"></span>
            </div>

        </div> <br><br>
          
           


       

        <button class="btn btn-primary" type="button" id="reload66"  style="display:none" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            editing...
        </button>

        <button type="button" style="margin-right: 2%"  id="update_users" onclick="do_update()" class="btn btn-primary">تعديل</button>

        <br><br><br><br>   <br><br><br><br>

    </form>
@endsection

@section('js')

<script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>

<script>
        
    function msg_add(){

        Swal.fire({
            position: 'top-start',
            icon: 'success',
            title: 'تمت الاضافة بنجاح ',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
            confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false

        });

    }

    function msg_edit(){

        Swal.fire({
            position: 'top-start',
            icon: 'success',
            title: 'تم التعديل بنجاح',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
            confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false

        });

    }

    function msg_delete(){

        Swal.fire({
            position: 'top-start',
            icon: 'success',
            title: 'تم الحذف بنجاح',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
            confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false

        });

    }

</script>


    <script>
        $(function() {
            'use strict';
            var changePicture = $('#change-picture'),
                userAvatar = $('.user-avatar');
            // Change user profile picture
            if (changePicture.length) {
                $(changePicture).on('change', function(e) {
                    var reader = new FileReader(),
                        files = e.target.files;
                    reader.onload = function() {
                        if (userAvatar.length) {
                            userAvatar.attr('src', reader.result);
                        }
                    };
                    reader.readAsDataURL(files[0]);
                });
            }
        });
    </script>


    <script>
        $(function() {
            'use strict';
            var changePicture = $('#change-picture2'),
                userAvatar = $('.user-avatar2');
            // Change user profile picture
            if (changePicture.length) {
                $(changePicture).on('change', function(e) {
                    var reader = new FileReader(),
                        files = e.target.files;
                    reader.onload = function() {
                        if (userAvatar.length) {
                            userAvatar.attr('src', reader.result);
                        }
                    };
                    reader.readAsDataURL(files[0]);
                });
            }
        });
    </script>


    <script>
        $(function() {
            'use strict';
            var changePicture = $('#change-picture3'),
                userAvatar = $('.user-avatar3');
            // Change user profile picture
            if (changePicture.length) {
                $(changePicture).on('change', function(e) {
                    var reader = new FileReader(),
                        files = e.target.files;
                    reader.onload = function() {
                        if (userAvatar.length) {
                            userAvatar.attr('src', reader.result);
                        }
                    };
                    reader.readAsDataURL(files[0]);
                });
            }
        });
    </script>


    {{-- update setting admin --}}
    <script>
        function do_update() {
            $('#email_error').text('');
            $('#password_error').text('');
            $("#update_users").css("display", "none");
            $("#reload66").css("display", "block");
            var formData = new FormData($('#usersFormUpdate')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{ route('dashboardsetting2') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    $("#reload66").css("display", "none");
                    $("#update_users").css("display", "block");
                  
                    $('#position-top-start_edit').click();
                    
                },
                error: function(reject) {
                    $("#reload66").css("display", "none");
                    $("#update_users").css("display", "block");
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                }
            });
        }
    </script>
@endsection
