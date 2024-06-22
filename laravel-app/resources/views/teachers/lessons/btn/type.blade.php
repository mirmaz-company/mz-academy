@if($data->type == "unvisable")

  مقفل <i class="fa fa-lock" style="color: red"></i>

@elseif($data->type == "visable")
   
    مرئي <i class="fa fa-eye" style="color: green"> </i>

@else

   اختبار <i class="fa fa-question" style="color: green"></i>

@endif
