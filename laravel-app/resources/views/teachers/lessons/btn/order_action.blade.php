
<div class="form-group">
    <div class="d-flex flex-column flex-md-row">
        <input type="number" class="form-control mb-2 mb-md-0" id="order{{$data->id}}" value="{{$data->order_index ?? ''}}">
        <span id="name_error" class="text-danger"></span>
    </div>
    
    <button class="btn btn-sm btn-primary mt-2 mt-md-0 ml-md-1" type="button" data-id="{{ $data->id }}" onClick="changeOrder('{{$data->id}}')">
        <i class="fa fa-check"></i>
    </button>
</div>


<script>
     
        function changeOrder(id){
            var order =  $('#order'+id).val()
            
           

            if(order === null || order === '' || !isNaN(order)) {
                 var csrfToken = "{{ csrf_token() }}";
                 
                $.ajax({
                    type: 'post',
                    url: "{{route('teachers.changeOrderIndex')}}",
                    data: {
                        _token: csrfToken,
                        lesson_id: id,
                        order_index: order
                    },
                    success: function (data) {
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        // $('#position-top-not_added5556').click();
                        
                        msg_edit();
                    },
                    error: function (reject) {
                        // Handle error
                        if (reject.responseJSON && reject.responseJSON.message) {
                            show_error(reject.responseJSON.message);
                        } else {
                            // If no specific error message is available, show a generic error
                            show_error('An error occurred while processing your request.');
                        }
                    }
                });
            }
         
       
        }
</script>

