<a class="btn btn-primary" data-toggle="modal" href="#edit_user"

data-id=             "{{ $data->id }}"
data-name=           "{{ $data->name }}"
data-email=          "{{ $data->email }}"
data-mobile=         "{{ $data->mobile }}"
data-password=       "{{ $data->password }}"

>{{ trans('main_trans.edit') }}</a>



<a class="btn btn-danger" data-toggle="modal" href="#delete_user"
data-id=             "{{ $data->id }}"
>{{ trans('main_trans.delete') }}</a>