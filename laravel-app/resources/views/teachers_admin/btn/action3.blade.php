{{-- <div class="col-md-3">

    @if($data->vdociper_or_bunny == 'bunny')
        <a class="btn btn-sm btn-success" onclick="conver_upload('{{ $data->id }}')" id="show{{ $data->id }}"  title=" تحويل الرفع الي فودوسايفر"
            data-id55=             "{{ $data->id }}"
        > تحويل الرفع الي فودوسايفر </a>

        <div class="spinner-border text-success" role="status"  style="display:none" id="hide{{ $data->id }}">
            <span class="sr-only text-success">Loading...</span>
        </div>
    @else
        <a class="btn btn-sm btn-success" onclick="conver_upload('{{ $data->id }}')" id="show{{ $data->id }}"  title="تحويل الرفع الى بني"
            data-id55=             "{{ $data->id }}"
        >تحويل الرفع الى بني </a>

        <div class="spinner-border text-success" role="status"  style="display:none" id="hide{{ $data->id }}">
            <span class="sr-only text-success">Loading...</span>
        </div>
    @endif

</div> --}}


<a class="btn btn-sm btn-primary" data-toggle="modal" href="#vdociper_or_bunny_modal"
                
    data-id=                  "{{ $data->id }}"
    data-vdociper_or_bunny=                  "{{ $data->vdociper_or_bunny }}"


>  {{ $data->vdociper_or_bunny }} </a>