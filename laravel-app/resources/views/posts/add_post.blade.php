@extends('layouts.main_page')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">
   

    <style>
        .emoji {
            font-size: 25px;
            cursor: pointer;
        }
    </style>

@endsection


@section('content')


 <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 



     
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
        </li>
        <li class="breadcrumb-item"><a href="#">انشاء منشور </a>
        </li>
    </ol>
</div>



{{-- <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">{{ trans('main_trans.add') }}</a>  --}}

<h1 style="text-align: center">انشاء منشور</h1>


<div class="row">

    <div class="col-md-1">
        <button id="emoji-button" class="form-control btn btn-sm btn-primary">🙂</button> 
    </div>
  

</div>
<br>

    <div id="emoji-container" style="display: none;background: #ecebff;border-radius: 6%;">
        <span class="emoji">😃</span> 
        <span class="emoji">😊</span> 
        <span class="emoji">😍</span> 
        <span class="emoji">😭</span> 
        <span class="emoji">😡</span> 
        <span class="emoji">🤔</span>
        <span class="emoji">😎</span>
        <span class="emoji">🤗</span> 
        <span class="emoji">🙂</span> 
        <span class="emoji">🎉</span> 
        <span class="emoji">😷</span>
        <span class="emoji">😴</span>
        <span class="emoji">🤗</span>
        <span class="emoji">🤫</span>
        <span class="emoji">🤔</span>
        <span class="emoji">🤥</span>
        <span class="emoji">🤢</span>
        <span class="emoji">🤮</span>
        <span class="emoji">🤧</span>
        <span class="emoji">🥵</span>
        <span class="emoji">🥶</span>
        <span class="emoji">😇</span>
        <span class="emoji">🥳</span>
        <span class="emoji">🥺</span>
        <span class="emoji">🥴</span>
        <span class="emoji">😏</span>
        <span class="emoji">🤮</span>
        <span class="emoji">🤯</span>
        <span class="emoji">🥳</span>
        <span class="emoji">🤯</span>
        <span class="emoji">🥴</span>
        <span class="emoji">🤫</span>
        <span class="emoji">🥺</span>
        <span class="emoji">🥰</span>
        <span class="emoji">😎</span>
        <span class="emoji">🙂</span>
        <span class="emoji">🙁</span>
        <span class="emoji">😕</span>
        <span class="emoji">😟</span>
        <span class="emoji">😔</span>
        <span class="emoji">😖</span>
        <span class="emoji">😬</span>
        <span class="emoji">😱</span>
        <span class="emoji">😨</span>
        <span class="emoji">❤️</span>
        <span class="emoji">🧡</span>
        <span class="emoji">💛</span>
        <span class="emoji">💚</span> 
        <span class="emoji">💙</span> 
        <span class="emoji">💜</span> 
        <span class="emoji">🖤</span>
        <span class="emoji">💔</span>
        <span class="emoji">❣️</span> 
        <span class="emoji">💕</span> 
        <span class="emoji">💞</span> 
        <span class="emoji">💘</span> 
        <span class="emoji">💖</span>
        <span class="emoji">💗</span> 
        <span class="emoji">💓</span> 
        <span class="emoji">💝</span> 
    </div>

    <br>

    <form id="add_user_form">
        @csrf

        {{-- الصور التي احذفها بسجلها هان عشان اتجاهلها بالكونترولر --}}
        <input type="hidden" name="ignored_files" id="ignored_files">
        
        <textarea name="text_post" class="form-control" id="text_post" cols="30" rows="10"></textarea> <br>

        <div class="col-md-12" style="display:none" id="image_sele">
            <!-- Image preview container -->
            <div class="container">
                <div class="row">
                <div class="col-md-12">
                    <div id="imagePreview" class="row" style="width:50%"></div>
                </div>
                </div>
            </div>
            
            <!-- Image file input -->
            <div class="mt-5">
                <div class="row">
                <div class="col-md-3">
                    <label for="imageFileInput" class="btn btn-primary btn-block">اختر الصور </label>
                    <input type="file" name="image[]" id="imageFileInput" style="display: none;" accept=".png,.jpg,.JPEG,.gif,.TIFF,.RAW" multiple>
                </div>
                </div>
            </div>
        </div>

    

        <div class="col-md-3">
            <div class="form-group">
            
                <label for=""> اضافة صور او فيديو</label>
                <select class="form-control" id="image_or_video" name="image_or_video">
                    <option value="none_select" selected> لا يوجد  </option>
                    <option value="image_select">صور</option>
                    <option value="video_select">فيديو</option>
                </select>
            </div>
        </div>

        <div style="display: none" id="video_link">
            <label for=""> ضع رابط يوتيوب</label>
            <input type="text" class="form-control" name="video_link">
        </div>



        <button type="button" style="display: none" id="add_user2" class="btn btn-primary btn-block"> يتم النشر ...</button>
        <button type="button" id="add_user" class="btn btn-primary btn-block">نشر</button>

    </form>



{{-- modal add --}}
{{-- <div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">اضافة </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                       

                            <div class="col-md-12">
                                <label>اسم المدينة </label>
                                <div class="form-group">
                                    <input type="name" name="city" id="city"  class="form-control" />
                                    <span id="city_error" class="text-danger"></span>
                                </div>
                            </div>

                           
                        </div>
                        
                    
                
                    
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_user2" class="btn btn-primary btn-block">تتم الاضافة ...</button>
                        <button type="button" id="add_user" class="btn btn-primary btn-block">اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}


{{-- modal edit --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12"> 
                                <input type="hidden" name="id" id="id2">
                                <label>المدينة </label>
                                <div class="form-group">
                                    <input type="text" name="city" id="city2" class="form-control" />
                                    <span id="city2_error" class="text-danger"></span>
                                </div>
                            </div>
                            
                        
                    
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing2" class="btn btn-primary btn-block"> يتم التعديل ...</button>
                        <button type="button" id="editing" onclick="do_update()" class="btn btn-primary btn-block">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- delete user --}}
<div class="modal fade modal-danger text-left" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel120">حذف  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="delete_user_form">
                    @csrf
                    <input type="hidden" name="id" id="id3">
                     هل انت متأكد من عملية الحذف ؟    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="delete_user2" style="display: none" data-dismiss="modal">...يتم الحذف</button>
                        <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_user_button" data-dismiss="modal">تأكيد</button>
                    </div>
                </form>
        </div>
    </div>
</div>


 @endsection


@section('js')
    <script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>

    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>

  

    {{-- emojes --}}
    <script>
        var button = document.getElementById("emoji-button");
        var container = document.getElementById("emoji-container");
        var textarea = document.getElementById("text_post");

        button.addEventListener("click", function() {
            container.style.display = container.style.display === "none" ? "block" : "none";
        });

        var emojis = document.getElementsByClassName("emoji");
        for (var i = 0; i < emojis.length; i++) {
            emojis[i].addEventListener("click", function(event) {
        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;
        var selectedText = textarea.value.substring(start, end);
        var emoji = event.target.innerHTML;
        textarea.value = textarea.value.substring(0, start) + emoji + textarea.value.substring(end);
        textarea.selectionStart = start + emoji.length;
        textarea.selectionEnd = start + emoji.length;
   
    });
        }
    </script>

    <script>
      $(document).ready(function() {
        $("#image_or_video").change(function() {
            if ($(this).val() == "image_select") {
                $("#video_link").css("display", "none");
                $("#image_sele").css("display", "block");
            }else if($(this).val() == "video_select"){
                $("#video_link").css("display", "block");
                $("#image_sele").css("display", "none");
            }else{
                $("#video_link").css("display", "none");
                $("#image_sele").css("display", "none");
            }
        });
       });
    </script>


    <script>
        $(document).ready(function() {
            //Auto-resizing textarea
            $("#text_post").on('input', function(){
                $(this).height(0);
                $(this).height(this.scrollHeight);
            });
        });
    </script>



    

 
    <!-- JavaScript code -->
<script>
        // Get the input element and the preview container
        const inputElement = document.getElementById("imageFileInput");
        const previewContainer = document.getElementById("imagePreview");
    
        // Add an event listener to the input element
        const ignoredFiles = [];
            inputElement.addEventListener("change", () => {
            // Get the selected files
            const files = inputElement.files;
            let finalFilesList = [];
        
            // Loop through the selected files
            for (let i = 0; i < inputElement.files.length; i++) {
            // Get the current file
            const file = inputElement.files[i];
            finalFilesList.push(file);
        
            // Check if the file is an image
            if (file.type.startsWith("image/")) {
                // If the file is an image, create a new FileReader object and read the file as a data URL
                const reader = new FileReader();
                reader.onload = () => {
                // Create a new image element and set its src to the reader's result
                const fileElement = document.createElement("img");
                fileElement.src = reader.result;
                fileElement.className = "img-fluid img-thumbnail";
        
                // Create a delete button
                const deleteButton = document.createElement("button");
                deleteButton.innerHTML = "Delete";
                deleteButton.className = "btn btn-link";
                deleteButton.style.color = "red";
                deleteButton.style.fontSize = "14px";
                deleteButton.style.marginTop = "8px";
                deleteButton.style.background = "#ffe7e7";
                deleteButton.onclick = () => {
        
                    // Remove the file from the preview container
                    previewContainer.removeChild(divElement);
                    remove_file(i);
                    console.log(ignoredFiles)
        
                    
                };
        
                // Create a new div element and append the file and delete button to it
                const divElement = document.createElement("div");
                divElement.className = "col-md-4";
                divElement.appendChild(fileElement);
                divElement.appendChild(deleteButton);
        
                // Append the div element to the preview container
                previewContainer.appendChild(divElement);
                };
                reader.readAsDataURL(file);
            } else {
                // If the file is not an image, create a new object URL for the file
                const fileUrl = URL.createObjectURL(file);
        
                // Create a new file element
                const fileElement = document.createElement("a");
                fileElement.href = fileUrl;
                fileElement.textContent = file.name;
                fileElement.className = "d-block text-center text-secondary";
                fileElement.style.background = "#f0f0f0";
        
        
            
        
                // Create a delete button
                const deleteButton = document.createElement("button");
                deleteButton.innerHTML = "Delete";
                deleteButton.className = "btn btn-link";
                deleteButton.style.color = "red";
                deleteButton.style.fontSize = "14px";
                deleteButton.style.marginTop = "8px";
                deleteButton.style.background = "#ffe7e7";
                deleteButton.onclick = () => {
                // Remove the file from the preview container and revoke the object URL
                previewContainer.removeChild(divElement);
                URL.revokeObjectURL(fileUrl);
                // console.log('1111111111111111', inputElement.files)
                // remove(inputElement.files[i]);
                remove_file(i);
                console.log(ignoredFiles)
          };
    
        
    
    
            // Create a new div element and append the file and delete button to it
            const divElement = document.createElement("div");
                divElement.className = "col-md-4";
                divElement.appendChild(fileElement);
                divElement.appendChild(deleteButton);
        
                // Append the div element to the preview container
                previewContainer.appendChild(divElement);
            };
        }
    
    
        //   inputElement.files = FileList(finalFilesList);
        //   console.log(inputElement.files)
    
        
     });


     
        function remove_file(i){
            ignoredFiles.push(i);
            $('#ignored_files').val(ignoredFiles.join(','))
        }

    
</script>



        <script>
            
            function msg_add(){
    
                Swal.fire({
                    position: 'top-start',
                    icon: 'success',
                    title: '  تم نشر المنشور بنجاح ',
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

        {{-- show information in yajradatatable --}}
        <script type="text/javascript">
        
            $(function () {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('teachers.get_all_cities') }}",
                columns: [
                    {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'city'         ,name: 'city'},

                    {data: 'action'     ,   name: 'action'},
                ],
                "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
            });
            });
        </script>
        {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}


    
        {{-- open modal add user --}}
        <script>
            $('#modal_add').on('show.bs.modal', function(event) {
                $('#city').text('');
            
            })
    </script>

<script>
    $(function () {
        'use strict';
        var changePicture = $('#change-picture'),
            userAvatar = $('.user-avatar');
        // Change user profile picture
        if (changePicture.length) {
            $(changePicture).on('change', function (e) {
                var reader = new FileReader(),
                    files = e.target.files;
                reader.onload = function () {
                    if (userAvatar.length) {
                        userAvatar.attr('src', reader.result);
                    }
                };
                reader.readAsDataURL(files[0]);
            });
        }
    });
</script>




    {{-- add user --}}
    <script>
        $(document).on('click', '#add_user', function (e) {
            // $('#name_error').text('');
   
       
            $("#add_user2").css("display", "block");
            $("#add_user").css("display", "none");
            var formData = new FormData($('#add_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('store_posts')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        
                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                            $("#add_user2").css("display", "none");
                            $("#add_user").css("display", "block");
                            $("#ignored_files").val("");
                            $('.close').click();
                            $('#position-top-start').click();
                            location.reload();
                 
                    },
                    error: function (reject) {
                        $("#add_user2").css("display", "none");
                        $("#add_user").css("display", "block");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                    }
                });
            });
    </script>


    {{-- edit user --}}
    <script>
        $('#edit_user').on('show.bs.modal', function(event) {
        
            var button = $(event.relatedTarget)
            var id =                  button.data('id')
            var city =                button.data('city')
            
            
            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #city2').val(city);
      
  
        })
    </script>


   {{-- update user --}}
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
                    url: "{{route('teachers.update_cities')}}",
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

    {{-- fill delete modal user --}}
    <script>
        $('#delete_user').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>


   {{-- delete user--}}
   <script>
        function do_delete(){

            $("#delete_user_button").css("display", "none");
            $("#delete_user2").css("display", "block");
            var formData = new FormData($('#delete_user_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('teachers.destroy_cities')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#delete_user2").css("display", "none");
                    $("#delete_user_button").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_delete').click();
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                
                }, error: function (reject) {
                }
            });
     }
   </script>



@endsection