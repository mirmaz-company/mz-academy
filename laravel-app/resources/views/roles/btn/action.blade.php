

        <a class="btn btn-sm btn-primary" 
            href="{{ route('roles.show', $data->id) }}" > 
             
            <i class="fa fa-show"></i>عرض الصلاحيات </a>



        <a class="btn btn-sm btn-primary" 
             href="{{ route('roles.edit', $data->id) }}" > 
            <i class="fa fa-edit"></i></a>

           
            @if ($data->name !== 'سوبر ادمن')

                {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',
                            $data->id], 'style' => 'display:inline']) !!}
                    {!! Form::submit('حذف', ['class' => 'btn btn-sm btn-danger']) !!}
                {!! Form::close() !!}

            @endif








