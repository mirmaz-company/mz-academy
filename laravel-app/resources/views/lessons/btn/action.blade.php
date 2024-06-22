

@if($data->updated_at < \Carbon\Carbon::now()->subHours(1)->toDateTimeString())

        @if($data->is_scheduler == 0)
                <?php $m = $data->form_date . ' ' . $data->date; ?>
                <p style='color:blue;font-size:12px'>{{ $m }} مجدول</p>
        @else
                <p style='color:green'>  تم النشر</p>
        @endif

@else


        <a class="btn btn-sm btn-primary" onclick="publish_now('{{ $data->id }}')" id="pu{{ $data->id }}"


        >  نشر الدرس الان </a>

       <span id="loading6{{ $data->id }}" style="display: none">جاري نشر الدرس الان .. </span>
 @endif
   






