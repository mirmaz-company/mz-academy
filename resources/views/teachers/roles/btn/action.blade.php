

        <a class="btn btn-sm btn-primary" 
            href="{{ route('teachers.roles.show', $data->id) }}" > 
             
            <i class="fa fa-show"></i>عرض الصلاحيات </a>



        <a class="btn btn-sm btn-primary" 
             href="{{ route('teachers.roles.edit', $data->id) }}" > 
            <i class="fa fa-edit"></i></a>

           
            {{-- @if ($data->name !== 'سوبر ادمن')

                {!! Form::open(['method' => 'DELETE', 'route' => ['teachers.roles.destroy',
                            $data->id], 'style' => 'display:inline']) !!}
                    {!! Form::submit('حذف', ['class' => 'btn btn-sm btn-danger']) !!}
                {!! Form::close() !!}

            @endif --}}








