

<?php $delivery_card = \App\Models\DeliveryCard::where('id',$data->id)->first(); ?>

@if($delivery_card)

    @if($delivery_card->status == 'new')

        <button class="btn btn-success btn-sm" id="accept{{ $data->id }}" onclick="accept('{{ $data->id }}','{{ $data->user_id }}')">قبول</button>
        <button class="btn btn-danger btn-sm"  id="deny{{ $data->id }}"   onclick="deny('{{ $data->id }}','{{ $data->user_id }}')">رفض</button>

    @elseif($delivery_card->status == 'accept')

        <div style="display: flex;gap:4px">
            <div>
                <button class="btn btn-primary btn-sm" id="delivery{{ $data->id }}" onclick="delivery('{{ $data->id }}','{{ $data->user_id }}')"> التحويل الى جاري التوصيل</button>
            </div>
            <div>

                <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
                data-id=             "{{ $data->id }}"
                data-user_id=             "{{ $data->user_id }}"
                >الغاء الطلب</a>
            </div>
        </div>

      


    @elseif($delivery_card->status == 'delivery')

    <div style="display: flex;gap:4px">

        <div>
            <button class="btn btn-primary btn-sm" id="done{{ $data->id }}" onclick="done('{{ $data->id }}','{{ $data->user_id }}')">التحويل الى انتهى  </button>
        </div>

        <div>
            <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
            data-id=             "{{ $data->id }}"
            data-user_id=             "{{ $data->user_id }}"
            >الغاء الطلب</a>
        </div>

    </div>

     

       


   @elseif($delivery_card->status == 'accept')

        <span style="color:red"> الطلب مرفوض</span>

    @else


    @endif



 @endif