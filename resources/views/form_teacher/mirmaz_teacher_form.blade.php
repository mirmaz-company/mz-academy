<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta http-equiv="X-UA-Compatible" content="ie=edge">-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/custom-rtl.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style-rtl.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@500;700&display=swap" rel="stylesheet">

    <title>استمارة</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">


    <style>

        body {
          background-image: url('{{ asset('back_mir.png') }}');
          background-repeat: no-repeat;
          background-size: cover;
          background-attachment: fixed;
          font-family: 'Amiri', serif;
          font-family: 'Cairo', sans-serif;
        

        }
        
        @media only screen and (min-width: 900px) {
          #conta {
           padding:0 8% 8% 8%;
          }
        }
        @media only screen and (max-width: 900px) {
          #m34 {
           padding:1%;
          }
          #m33 {
           width:60%;
        
          }
         
        }
        @media only screen and (min-width: 900px) {
       
          #m33 {
           width:26%;
        
          }
         
        }


        
        
        
    </style>
       

       



</head>
<body>

    <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button> 
    <button class="btn btn-outline-primary" style="display: none" onclick="is_found2()" id="position-top-is_found"></button> 
    <button class="btn btn-outline-primary" style="display: none" onclick="is_found22()" id="position-top-is_found2"></button> 
    <button class="btn btn-outline-primary" style="display: none" onclick="is_found223()" id="position-top-is_found3"></button> 
    <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button> 
    <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 
    <button class="btn btn-outline-primary" style="display: none" onclick="email_error2()" id="position-top-email_error"></button> 
    <button class="btn btn-outline-primary" style="display: none" onclick="mobile_error2()" id="position-top-mobile_error"></button> 

    <div style="background: rgb(255, 255, 255) ;padding:1%;margin: auto"> 
      
       <div style="margin: auto;text-align: center;" id="m34">
      
            <img src="{{ asset('mir_logo.png') }}" id="m33" alt=""  >
       </div>

    </div>


    {{-- فورم الاستمارة --}}
    
    <div id="conta">
    <div style="margin-top:2%">
        <h3 style="text-align: center;font-size:16px">استمارة التسجيل</h3>
        <h1 style="text-align: center;font-size:25px;font-weight: bold">الخاصة بالاساتذة والمدرسين</h1>

        <form id="add_user_form">
            @csrf
            <div class="modal-body">
                <div class="row">
                   
                    <div class="col-md-12">
                        <h3 style="text-align: center;font-size:16px">مرحبًا بك في منصة مرماز أكاديمي التعليمية

                            لمدرسي ومعلمي جميع المراحل الدراسية ، ولكل المواد
                            أسهل منصة شرح مباشر و تفاعلي تجمعك بطلابك وأنت مكانك وبكل الأدوات التي تحتاجها .. ! 
                             
                            للإطلاع على مزايا المنصة وما تقدمه لك بالتفصيل  <span style="color:blue;font-size:20px"> <a href="{{ route('book_pdf') }}" target="_blank">اضغط هنا</a></span></h3> 

                       <h1 style="font-size:16px;font-weight: bold">* البيانات الشخصية </h1>
                    </div> <br>
               

                    <div class="col-md-6">
                        <label>الاسم  </label>
                        <div class="form-group">
                            <input type="text" name="name" id="name"  class="form-control" placeholder="ادخل اسمك.." />
                            <span id="name_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>التحصيل الدراسي  </label>
                        <div class="form-group">
                            <input type="text" name="collection_school" id="collection_school"  class="form-control" placeholder="ادخل تحصيلك الدراسي" />
                            <span id="collection_school_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label> المحافظة  </label>
                        <div class="form-group">
                            <input type="text" name="governorate" id="governorate"  class="form-control" placeholder="ادخل المحافظة التي تسكنها حاليا.." />
                            <span id="governorate_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label> العنوان  </label>
                        <div class="form-group">
                            <input type="text" name="address" id="address"  class="form-control" placeholder="ادخل عنوانك الحالي.." />
                            <span id="address_error" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-top:3%">
                        <h1 style="font-size:16px;font-weight: bold"> *بيانات التواصل</h1>
                    </div><br>

                    <div class="col-md-6">
                        <label> رقم الهاتف  </label>
                        <div class="form-group">
                            <input type="text" name="phone" id="phone"  class="form-control" placeholder="ادخل رقم الهاتف الخاص بك" />
                            <span id="phone_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>  البريد الالكتروني  </label>
                        <div class="form-group">
                            <input type="text" name="email" id="email"  class="form-control" placeholder="ادخل بريدك الالكترني (الايميل)" />
                            <span id="email_error" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-top:3%">
                      <h1 style="font-size:16px;font-weight: bold"> * التخصص</h1>
                    </div><br>


                    <div class="col-md-6">
                        <label>  المادة  </label>
                        <div class="form-group">
                            <input type="text" name="subject" id="subject"  class="form-control" placeholder="ادخل المادة التي تريد تدريسها" />
                            <span id="subject_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>  المراحل الدراسية  </label>
                        <div class="form-group">
                            <input type="text" name="level" id="level"  class="form-control" placeholder="ادخل المراحل الدراسية التي تريد تدريسها" />
                            <span id="level_error" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-top:3%">
                         <h1 style="font-size:16px;font-weight: bold"> * التعليمات</h1>
                    </div><br>
                   <div class="col-md-12">
                    <h5 style="font-size:12px">

                         - يمنع نشر أي محتوى يتسبب بضرر مباشر أو غير مباشر لنا أو لأي من مستخدمي خدماتنا. <br><br>

                      -  يمنع القيام بأي أعمال تنتقص أو تحط من قدرنا أو قدر الآخرين أو من منتجاتنا أو خدماتنا.  <br><br>

                      -  حقك في استخدام منصة مرماز أكاديمي هو شخصي لك ولا يسمح لك بمنح هذا الحق لأي شخص آخر لاستخدام حسابك تحت اسمك أو نيابة عنك   <br><br>
                        .

                       - يمنع تبادل أرقام الهواتف الشخصية أو العناوين المنزلية أو تداول حسابات مواقع التواصل الاجتماعي الشخصية أو الاتفاق على عمل لقاءات خارجية مع الطلاب.  <br><br>

                     - منصة مرماز أكاديمي لها الحق بالحصول على نسبة 15% من كل اشتراك مقابل الخدمات المقدمة، وفي حال مخالفة أي اجراءات للمنصة سيكون لنا الحق الكامل بإنهاء اشتراكك في الخدمات دون سابق إنذار واتخاذ أي اجراءات آخرى نراها مناسبة 
                     <br><br>  - إلتزام الأساتذة بنشر جدول المحاضرات الأسبوعي للطلبة.


                    </h5>
                    </div>

                    

                   
                </div>
                </div>
                
            
        
            
              
            </div>
            <div class="modal-footer">
                
                <button type="button" id="add_user" style="width: 25%;margin: auto;" class="btn btn-primary btn-block">ارسال</button>
            </div>
        </form> <br><br><br><br><br><br><br><br><br><br><br><br>
  
        <div style="text-align: center;margin-top: -5%;">

            <a target="_blank" href="https://www.facebook.com/Mirmaz.Academy/">
                <img src="{{ asset('facebook.svg') }}" alt="">
            </a>
            <a target="_blank" href="Https://mirmaz-academy.com">
                <img src="{{ asset('web.svg') }}" alt="">
            </a>

            <a target="_blank" href="https://wa.me/+9647740002767">
               <img src="{{ asset('whats.svg') }}" alt="">
            </a>

            <a target="_blank" href="https://www.instagram.com/mirmaz.academy/">
               <img src="{{ asset('instagram.svg') }}" alt="">
            </a>

            <a target="_blank" href="https://t.me/mirmaz_academy">
               <img src="{{ asset('telegram.svg') }}" alt="">
            </a>



          
        </div> <br>
    
    
        </div>
    </div>

 
      
  

   



    {{-- modal download form --}}
    <div class="form-modal-ex">
        <div class="modal fade text-left" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> تم ارسال الطلب بنجاح  </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('generate_pdf') }}">
                        @csrf
                        <div class="modal-body2">
                            <div class="row">

                                <input type="hidden" name="id" id="id2">
                        
                            </div>
                        </div>
                        <div class="modal-footer">
                     
                            {{-- <button type="button" style="display: none" id="editing2" class="btn btn-primary btn-block">  جاري التنزيل ...</button> --}}
                            <button type="submit"  class="btn btn-primary btn-block">تنزيل نسخة من الطلب</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <script src="{{asset('app-assets/jquery.min.js')}}"></script> --}}
    <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>

    <!-- BEGIN Vendor JS-->


    <script>
        
        function msg_add(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: ' تم ارسال الطلب بنجاح ',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function is_found2(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'error',
                title: ' الايميل مستخدم ',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function is_found22(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'error',
                title: ' الجوال مستخدم ',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function is_found223(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'error',
                title: ' الجوال والايميل موجودين مسبقا ',
                showConfirmButton: false,
                timer: 2000,
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
                timer: 2000,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }

        function msg_delete(){

            Swal.fire({
                position: 'top-start',
                icon: 'error',
                title: 'تحقق من البيانات المدخلة بشكل صحيح  ',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
          }
        function email_error2(){

            Swal.fire({
                position: 'top-start',
                icon: 'error',
                title: ' الايميل غير صالح ',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
          }
        function mobile_error2(){

            Swal.fire({
                position: 'top-start',
                icon: 'error',
                title: ' رقم الجوال المدخل غير صالح  ',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
          }

    </script>

    
    {{-- add user --}}
    <script>
        $(document).on('click', '#add_user', function (e) {
      
            // $('#name_error').text('');
   
       
            // $("#add_user2").css("display", "block");
            $("#add_user").html("يتم الارسال");
            var formData = new FormData($('#add_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('form_teacher')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                        if(data.status == false){
                            $("#add_user").html(" ارسال");
                            $('#position-top-start_delete').click();
                            $("#add_user2").css("display", "none");
                            $("#add_user").css("display", "block");
                        }else if(data.status == "is_found"){
                            $('#position-top-is_found').click();
                            $("#add_user").html(" ارسال");
                        

                        }else if(data.status == "mobile_error"){
                              $('#position-top-mobile_error').click();
                              $("#add_user").html(" ارسال");
                        }
                        
                        else if(data.status == "email_error"){
                            $('#position-top-email_error').click();
                            $("#add_user").html(" ارسال");

                        }
                        else if(data.status == "is_found2"){
                            $('#position-top-is_found2').click();
                            $("#add_user").html(" ارسال");
                        
                        }else if(data.status == "is_found3"){
                            $('#position-top-is_found3').click();
                            $("#add_user").html(" ارسال");
                        }
                        else{
                            $('#edit_user').modal('show');
                         

                           $('.modal-body2 #id2').val(data.id);
                       
                        


                            $("#add_user").html(" ارسال");
                            // $('#position-top-start').click();
                            $("#add_user2").css("display", "none");
                            $("#add_user").css("display", "block");
                        }
                 
                    },
                    error: function (reject) {
                        $("#add_user").html(" ارسال");
                        // $("#add_user2").css("display", "none");
                        // $("#add_user").css("display", "block");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                    }
                });
            });
    </script>


   {{-- donwload pdf  --}}
   <script>
    function do_update(){
    
        $('#title2_error').text('')
        $('#body2_error').text('')

        
        $("#editing").css("display", "none");
        $("#editing2").css("display", "block");

        var formData = new FormData($('#edit_user_form')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{route('generate_pdf')}}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    $("#editing").css("display", "block");
                    $("#editing2").css("display", "none");
            
                    $('.close').click();
                
                    $('#position-top-start_edit').click();
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                
                }, error: function (reject) {
                        $("#editing").css("display", "block");
                        $("#editing2").css("display", "none");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "2_error").text(val[0]);
                        });
                }
            });
    }
</script>
   
    
</body>
</html>