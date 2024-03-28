<div class="col-md-4" id="">
        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#accept_user"

        <?php $user_name = $data->full_name;  ?>
        <?php $message =" هل انت متاكد ان "  ;?>
        <?php $message2 =" وثائقه سليمة" ;  ?>

        data-id=             "{{ $data->id }}"
        data-messge_accept=  "{{ $message . $user_name . $message2}}"

        > قبول</a>
    </div>

    {{-- <div class="col-md-4" id="show{{ $data->id }}">
        <a class="btn btn-sm btn-danger" onclick="decline('{{ $data->id }}')"


        > رفض </a>
    </div> --}}

   <div class="col-md-4" id="show{{ $data->id }}">
        <a class="btn btn-sm btn-danger" data-toggle="modal" href="#edit_user"

            data-id=             "{{ $data->id }}"
            data-user_id=        "{{ $data->user_id }}"
    
        > رفض</a>
    </div>

    <div class="spinner-border" role="status" id="hide{{ $data->id }}" style="display: none">
        <span class="sr-only">Loading...</span>
    </div>
