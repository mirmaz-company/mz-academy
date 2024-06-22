
<div class="row">

    @if($type == "active" || $type == "inactive")

    @can("تعديل مستخدم")
        <div class="col-md-3">
            <a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user"

            data-id=             "{{ $data->id }}"
            data-name=           "{{ $data->name }}"
            data-email=          "{{ $data->email }}"
            data-mobile=         "{{ $data->mobile }}"
            data-password=       "{{ $data->password }}"

            @if($data->image == NULL)
            
            data-image=       "{{ url('attachments/profile/default.webp') }}"

            @else

            data-image=       "{{ $data->image }}"

            @endif
        
    

            > <i class="fa fa-edit"></i> </a>
        </div>
        @endcan

        @can("ارسال اشعار")
        <div class="col-md-3">
            <a class="btn btn-sm btn-primary" data-toggle="modal" href="#inlineForm_not"

            data-id55=             "{{ $data->id }}"


            > <i class="fa fa-bell"></i> </a>
        </div>
        @endcan

        @can("حذف مستخدم")
        <div class="col-md-3">
                
            <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
            data-id=             "{{ $data->id }}"
            ><i class="fa fa-trash"></i></a>
        </div>
        @endcan


        <div class="col-md-3">

            <a class="btn btn-sm btn-success" onclick="reset_login('{{ $data->id }}')" id="show{{ $data->id }}"  title="اعادة تعيين الجهاز"
                data-id55=             "{{ $data->id }}"
            > <i class="fa fa-refresh"></i> </a>

            <div class="spinner-border text-success" role="status"  style="display:none" id="hide{{ $data->id }}">
                <span class="sr-only text-success">Loading...</span>
            </div>

        </div>


    @else


        <div class="col-md-4" id="">
            <a class="btn btn-sm btn-primary" data-toggle="modal" href="#accept_user"

            <?php $user_name = $data_verified->full_name;  ?>
            <?php $message =" هل انت متاكد ان "  ;?>
            <?php $message2 =" وثائقه سليمة" ;  ?>

            data-id=             "{{ $data->id }}"
            data-messge_accept=  "{{ $message . $user_name . $message2}}"
    
            > قبول</a>
        </div>

        <div class="col-md-4" id="show{{ $data->id }}">
            <a class="btn btn-sm btn-danger" onclick="decline('{{ $data->id }}')"

    
            > رفض </a>
        </div>

        <div class="spinner-border" role="status" id="hide{{ $data->id }}" style="display: none">
            <span class="sr-only">Loading...</span>
        </div>



    @endif
    

</div>





