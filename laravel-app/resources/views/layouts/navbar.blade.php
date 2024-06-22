   <!-- BEGIN: Header-->
   <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>
            <ul class="nav navbar-nav bookmark-icons">
             
            </ul>
            <ul class="nav navbar-nav">
                <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"></a>
                    <div class="bookmark-input search-input">
                        <div class="bookmark-input-icon"><i data-feather="search"></i></div>
                        <input class="form-control input" type="text" placeholder="Bookmark" tabindex="0" data-search="search">
                        <ul class="search-list search-list-bookmark"></ul>
                    </div>
                </li>
            </ul>
        
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">

           
            
            {{-- <li class="nav-item dropdown dropdown-language"><a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-{{ LaravelLocalization::getCurrentLocale() == "ar" ? "jo" :"us" }}"></i><span class="selected-language">{{ LaravelLocalization::getCurrentLocale() }}</span></a>
                
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    
                            <a rel="alternate" class="dropdown-item" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                               
                                 {{ $properties['native'] }}</a>
                            </a>
                           
                    
                    @endforeach
                </div>
            </li> --}}

            @if(Auth::guard('web')->check())

            <li class="nav-item dropdown dropdown-cart mr-25">
                <a class="nav-link" href="javascript:void(0);" data-toggle="dropdown">
                <?php $user_proxy = \App\Models\Proxy::orderBy('id','desc')->get();?>
                <?php $user_proxy_count = \App\Models\Proxy::where('read_at',1)->orderBy('id','desc')->count();?>
                    <i class="ficon"  data-feather='bell'></i>
                    <span class="badge badge-pill badge-danger badge-up cart-item-count">{{$user_proxy_count}}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                    <li class="scrollable-container media-list" style="padding:3%">


                        <h3>  الاشخاص الذين سربو الفيديوهات </h3>

                        @foreach($user_proxy as $user_pro)
                     
                        <div class="media align-items-center">
                            @csrf
                            <!--<img class="d-block rounded mr-1" src="{{$user_pro->photo}}" alt="donuts" width="62">-->
                            <div class="media-body">
                                <div class="media-heading">
                                    <h6 class="cart-item-title">
                                         <?php $user_name = \App\Models\User::where('id',$user_pro->user_id)->first();?>
                                    
                                            <a class="text-body" href="{{route('profile_user',$user_pro->user_id)}}"> {{$user_name->name}}</a>
                                    </h6>
                                   <p>{{$user_pro->text}}</p>
                                </div>
                                 <button class="btn btn-primary delete_user_proxy" data-id="{{$user_name->id}}">فك الحظر</button>
                            </div>
                        </div>
                    
                        @endforeach


                    </li>

                  

                </ul>
            </li>
            @endif

            @if(Auth::guard('teachers')->check())
                @if(Auth::guard('teachers')->user()->parent == 0)
            

                <li class="nav-item dropdown dropdown-cart mr-25">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="dropdown">
                    <?php $courses_teachers = \App\Models\Course::where('teacher_id',Auth::guard("teachers")->user()->id)->pluck('id')?>
                    <?php $userg = \App\Models\User::where('mobile',"009647703391199")->first(); ?>
                    <?php $noti_teacher = \App\Models\NotificationTeacher::where('teacher_id',Auth::guard('teachers')->user()->id)->where('seen',NULL)->orderBy('id','desc')->get();?>
                    <?php $noti_teacher2 = \App\Models\NotificationTeacher::where('teacher_id',Auth::guard('teachers')->user()->id)->orderBy('id','desc')->get();?>
                
                    <i class="ficon"  data-feather='bell'></i>
                    <span class="badge badge-pill badge-danger badge-up cart-item-count">{{$noti_teacher->count()}}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">

                        @if($noti_teacher->count() != 0)
                            <?php $noti_teacher = \App\Models\NotificationTeacher::where('teacher_id',Auth::guard('teachers')->user()->id)->orderBy('id','desc')->take(5)->get();?>
                            @foreach($noti_teacher as $not)
                                <li class="scrollable-container media-list"><a class="d-flex" href="javascript:void(0)">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left">
                                            <div class="avatar"><img src="{{ asset('mimaz.png') }}" alt="avatar" width="32" height="32"></div>
                                        </div>
                                    <a href="{{ route('teachers.notification_teacher') }}">       <p><span class="font-weight-bolder">{{ \Illuminate\Support\Str::limit($not->title , 40, $end='...') }} <br> <span style="color:black;font-weight: 100">{{ \Illuminate\Support\Str::limit($not->description , 40, $end='...') }}</span> </small> <br></a>
                                     
                                                
                                  
                                    </div>
                                    
                                </a>
                                <a class="d-flex" href="javascript:void(0)">
                            
                                </a>
                            @endforeach


                        </li>
                        <li class="dropdown-menu-footer"><a class="btn btn-primary btn-block" href="{{ route('teachers.notification_teacher') }}">قراءة جميع الاشعارات</a></li>

                        @elseif($noti_teacher2->count() != 0)
                            <?php $noti_teacher = \App\Models\NotificationTeacher::where('teacher_id',Auth::guard('teachers')->user()->id)->orderBy('id','desc')->take(5)->get();?>
                            @foreach($noti_teacher as $not)
                                <li class="scrollable-container media-list"><a class="d-flex" href="javascript:void(0)">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left">
                                            <div class="avatar"><img src="{{ asset('mimaz.png') }}" alt="avatar" width="32" height="32"></div>
                                        </div>
                                    <a href="{{ route('teachers.notification_teacher') }}">       <p><span class="font-weight-bolder">{{ \Illuminate\Support\Str::limit($not->title , 40, $end='...') }} <br> <span style="color:black;font-weight: 100">{{ \Illuminate\Support\Str::limit($not->description , 40, $end='...') }}</span> </small> <br></a>
                                    
                                                
                                
                                    </div>
                                    
                                </a>
                                <a class="d-flex" href="javascript:void(0)">
                            
                                </a>
                            @endforeach


                            </li>
                            <li class="dropdown-menu-footer"><a class="btn btn-primary btn-block" href="{{ route('teachers.notification_teacher') }}">قراءة جميع الاشعارات</a></li>

                        @else
                            <h2 style="text-align: center">لا يوجد اشعارات</h2>
                        @endif
                    </ul>
            </li>
                @endif
            @endif
      
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span class="user-name font-weight-bolder">
                        @if(Auth::guard('web')->check())
                              {{ Auth::user()->name }}
                        @else
                              {{ Auth::guard('teachers')->user()->name }}
                        @endif
                    </span><span class="user-status">Admin</span></div><span class="avatar">
                        @if(Auth::guard('web')->check())
                            @if(Auth::user()->image == NULL)
                                <img class="round" src="https://icons-for-free.com/iconfiles/png/512/business+costume+male+man+office+user+icon-1320196264882354682.png" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                                 
                            @else
                                <img class="round" src="{{ Auth::user()->image }}" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                               
                            @endif

                            
                        @else
                            @if(Auth::guard('teachers')->user()->image == NULL)

                                <img class="round" src="https://icons-for-free.com/iconfiles/png/512/business+costume+male+man+office+user+icon-1320196264882354682.png" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                            
                            @else
                                <img class="round" src="{{ Auth::guard('teachers')->user()->image  }}" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                            
                            @endif
                               
                        @endif

                        
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user"><a class="dropdown-item" href="{{ route('myprofile') }}"><i class="mr-50" data-feather="user"></i> 
                   Setting account</a>
                <div class="dropdown-divider"></div>
              
                    <a class="dropdown-item" href="{{ route('logout','web') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="mr-50" data-feather="power"></i>
                     Logout</a>
                     @if(auth('web')->check())
                     <form id="logout-form" action="{{ route('logout','web') }}" method="POST" style="display: none;">
                        @else
                        <form id="logout-form" action="{{ route('logout','teachers') }}" method="POST" style="display: none;">
                        @endif
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(".delete_user_proxy").click(function() {
            // Get the user id from the data attribute
            var userId = $(this).data("id");
            
            

            // AJAX request
            $.ajax({
                type: "POST",
                url: "{{route('delete_proxy_user')}}",
                data: {
                    _token:'{{ csrf_token() }}',
                    user_id: userId
                },
                success: function (response) {
                    // Handle success response
                    console.log("Success:", response);
                    location.reload();
                },
                error: function (error) {
                    // Handle error
                    console.log("Error:", error);
                }
            });
        });
 
         
</script>