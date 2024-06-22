<div class="custom-control custom-control-success custom-switch" id="cousome_switch"
      data-id= {{ $id }} 
      data-course_id = {{ $course_id }}>
    <input type="checkbox" {{ $status == 1 ? "checked" : "" }}  class="custom-control-input" id="customSwitch4{{ $id }}" />
    <label class="custom-control-label" for="customSwitch4{{ $id }}"></label>
 </div>
