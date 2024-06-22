    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <?php $image = \App\Models\Setting::pluck('image')->first() ?>
                <?php $name = \App\Models\Setting::pluck('dashboardname')->first() ?>
            
                <li class="nav-item mr-auto"><a class="navbar-brand" href=""><span class="brand-logo">
                  <img src="{{ $image }}" alt="">  </span>
                        <h2 class="brand-text">{{ $name }}</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>


            <div class="main-menu-content">
                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                    <?php $aa = LaravelLocalization::getCurrentLocale() ?>

             @can("الصفحة الرئيسية")
                    <li class=" nav-item {{ Route::is('main_statistic') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('main_statistic') }}"><i style="color:{{ Route::is('teachers.main_statistic') ? '#d2d2d2' : '#656565'}}" class="fa fa-home"></i><span style="color:{{ Route::is('main_statistic')  ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate">{{ trans('main_trans.main_page') }}</span></a></li>
             @endcan
           


              @can("المستخدمين")  
                    <li class=" nav-item"><a class="d-flex align-items-center" style="background: #d2d2d218" href="#"><i style="color:#656565" class="fa fa-users"></i><span style="color:#656565" class="menu-title text-truncate">المستخدمين</span></a>
                        <ul class="menu-content">
                            @can("المستخدمين الفعالين")
                            <li class=" nav-item {{ url()->current() == asset("/ar/users_all") ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('users_all') }}"><i style="color:{{ url()->current() == asset("/users_all") ? '#d2d2d2' : '#656565'}}" class="fa-brands fa-creative-commons-sampling"></i><span style="color:{{ url()->current() == asset("/ar//ar/users_all") ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate"> كل المستخدمين</span></a></li>
                            <li class=" nav-item {{ url()->current() == asset("/ar/users/active") ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('users','active') }}"><i style="color:{{ url()->current() == asset("/ar/users/active") ? '#d2d2d2' : '#656565'}}" class="fa-brands fa-creative-commons-sampling"></i><span style="color:{{ url()->current() == asset("/ar/users/active") ? '#0bff0b' : '#656565' }}" class="menu-title text-truncate">المستخدمين الفعالين</span></a></li>
                            @endcan
                            @can("المستخدمين غير الفعالين")
                            <li class=" nav-item {{ url()->current() == asset("/ar/users/inactive") ? 'active' : '' }} "><a class="d-flex align-items-center" href="{{ route('users','inactive') }}"><i style="color:{{ url()->current() == asset("/ar/users/inactive") ? '#d2d2d2' : '#656565'}}" class="fa-brands fa-creative-commons-zero"></i><span style="color:{{url()->current() == asset("/ar/users/inactive")  ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate"> غير فعالين </span></a></li>
                            @endcan
                            
                            @can("المرفوضين")
                            <li class=" nav-item {{ url()->current() == asset("/ar/users/decline") ? 'active' : '' }} "><a class="d-flex align-items-center" href="{{ route('users','decline') }}"><i style="color:{{ url()->current() == asset("/ar/users/decline") ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-xmark"></i><span style="color:{{ url()->current() == asset("/ar/users/decline") ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate"> المرفوضين </span></a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can("طلبات الموافقة")
                <li class=" nav-item {{ Route::is('accept_user')? 'active' : '' }} "><a class="d-flex align-items-center" href="{{ route('accept_user') }}"><i style="color:{{ Route::is('accept_user') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-check"></i><span style="color:{{ Route::is('accept_user') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">  طلبات الموافقة
                    <span style="background: red;border-radius: 33%; font-size: 96%; color: white;">
                        <?php $m = \App\Models\VerifiedData::where('status',0)->count(); ?>&nbsp; {{ $m }}&nbsp;&nbsp;</span>
                </span></a></li>
                {{-- <li class=" nav-item {{ Route::is('accept_user_new')? 'active' : '' }} "><a class="d-flex align-items-center" href="{{ route('accept_user_new') }}"><i style="color:{{ Route::is('accept_user_new') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-check"></i><span style="color:{{ Route::is('accept_user_new') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">  طلبات الموافقة*
                    <span style="background: red;border-radius: 33%; font-size: 96%; color: white;">
                        <?php $m = \App\Models\VerifiedDataNew::where('status',0)->count(); ?>&nbsp; {{ $m }}&nbsp;&nbsp;</span>
                </span></a></li> --}}
                @endcan
          
               
                @can("المعلمين")
                <li class=" nav-item {{ Route::is('teachers')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('teachers') }}"><i style="color:{{ Route::is('teachers') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-chalkboard-user"></i><span style="color:{{ Route::is('teachers') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">المدرسين</span></a></li>
                @endcan
                @can("الدراسة")
                <li class=" nav-item {{ Route::is('study')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('study') }}"><i style="color:{{ Route::is('study') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-school"></i><span style="color:{{ Route::is('study') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">الدراسة</span></a></li>
                @endcan
                @can("المراحل")
                <li class=" nav-item {{ Route::is('levels')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('levels') }}"><i style="color:{{ Route::is('levels') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-layer-group"></i><span style="color:{{ Route::is('levels') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">المراحل</span></a></li>
                @endcan
                @can("المواضيع")
                <li class=" nav-item {{ Route::is('subjects')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('subjects') }}"><i style="color:{{ Route::is('subjects') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-business-time"></i><span style="color:{{ Route::is('subjects') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">المواد الدراسية</span></a></li>
              
                @endcan
              
                @can("طلبات الدورات")
                <li class=" nav-item {{ Route::is('courses_accept')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('courses_accept') }}"><i style="color:{{ Route::is('courses_accept') ? '#d2d2d2' : '#656565'}}" class="fa-brands fa-usps"></i><span style="color:{{ Route::is('courses_accept')  ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate"> 
                  
                        طلبات الدورات
                        <span style="background: red;border-radius: 33%; font-size: 96%; color: white;">
                            <?php $m = \App\Models\Course::where('status',1)->count(); ?>&nbsp; {{ $m }}&nbsp;&nbsp;</span>
                    </a></li>
                @endcan
                @can("طلبات الاساتذة")
                <li class=" nav-item {{ Route::is('form_teacher')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('form_teacher') }}"><i style="color:{{ Route::is('form_teacher') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-check"></i><span style="color:{{ Route::is('form_teacher') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">طلبات الاساتذة
                
                    <span style="background: red;border-radius: 33%; font-size: 96%; color: white;">
                        <?php $m = \App\Models\FormTeacher::where('status',0)->count(); ?>&nbsp; {{ $m }}&nbsp;&nbsp;</span>
                </span></a></li>
                    @can("اكواد المحفظة")
                    <li class=" nav-item {{ Route::is('delivery_card')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('delivery_card') }}"><i style="color:{{ Route::is('delivery_card') ? '#d2d2d2' : '#656565'}}" class="fa-brands fa-cc-amazon-pay"></i><span style="color:{{ Route::is('delivery_card')  ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate">طلبات البطاقات
                    
                        <span style="background: red;border-radius: 33%; font-size: 96%; color: white;">
                            <?php $m = \App\Models\DeliveryCard::where('status',"new")->count(); ?>&nbsp; {{ $m }}&nbsp;&nbsp;</span>
                    </span></a></li>
                    @endcan
                @endcan
            
                @can('المحافظات')
                 <li class=" nav-item {{ Route::is('cities')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('cities') }}"><i style="color:{{ Route::is('cities') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-city"></i><span style="color:{{ Route::is('cities')  ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate">المحافظات</span></a></li>
                @endcan
               
                @can("اكواد المحفظة")
                <li class=" nav-item {{ Route::is('wallet_sections')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('wallet_sections') }}"><i style="color:{{ Route::is('wallet_sections') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-signature"></i><span style="color:{{ Route::is('wallet_sections') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">اكواد المحفظة</span></a></li>
                @endcan
                @can('المنشورات')
                <li class=" nav-item {{ Route::is('posts')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('posts') }}"><i style="color:{{ Route::is('posts') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-blog"></i><span style="color:{{ Route::is('posts') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate"> المنشورات</span></a></li>
                @endcan
                @can("الاهتمامات")
                <li class=" nav-item {{ Route::is('topics')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('topics') }}"><i style="color:{{ Route::is('topics') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-magnet"></i><span style="color:{{ Route::is('topics')  ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate">الاهتمامات</span></a></li>
               
                <li class=" nav-item {{ Route::is('purchasescard')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('purchasescard') }}"><i style="color:{{ Route::is('purchasescard') ? '#d2d2d2' : '#656565'}}" class="fa-brands fa-cc-amazon-pay"></i><span style="color:{{ Route::is('purchasescard')  ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate">البطاقات</span></a></li>
                @endcan
                @can("تقييمات التطبيق")
                <li class=" nav-item {{ Route::is('student_are_saying')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('student_are_saying') }}"><i style="color:{{ Route::is('student_are_saying') ? '#d2d2d2' : '#656565'}}" 
                    class="fa-solid fa-star"></i><span style="color:{{ Route::is('student_are_saying') ? '#d2d2d2' : '#656565' }}" 
                    class="menu-title text-truncate"> 
                    
                    تقييمات التطبيق
                    <span style="background: red;border-radius: 33%; font-size: 96%; color: white;">
                        <?php $m = \App\Models\StudentAreSaying::where('read_at',NULL)->count(); ?>&nbsp; {{ $m }}&nbsp;&nbsp;</span>
                </span></a></li>

                @endcan

                @can("ترجمة")
                   <li class=" nav-item {{ Route::is('languages')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('languages') }}"><i style="color:{{ Route::is('languages') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-earth-europe"></i><span style="color:{{ Route::is('languages') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">ترجمة</span></a></li>
                @endcan
                   
                @can('بحث عن اكواد')


                    <li class=" nav-item"><a class="d-flex align-items-center" style="background: #d2d2d218" href="#"><i style="color:#656565" class="fa fa-radiation"></i><span style="color:#656565" class="menu-title text-truncate">العمليات</span></a>
                        <ul class="menu-content">
                            <li class=" nav-item {{ Route::is('search_codes')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('search_codes') }}"><span style="color:{{ Route::is('search_codes') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">بحث عن الاكواد</span></a></li>
                            <li class=" nav-item {{ Route::is('add_student_to_course')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('add_student_to_course') }}"><span style="color:{{ Route::is('add_student_to_course') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate"> اضافة الطالب لدورة</span></a></li>
                            <li class=" nav-item {{ Route::is('last_used_codes')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('last_used_codes') }}"><span style="color:{{ Route::is('last_used_codes') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">اخر الاكواد المستخدمة</span></a></li>
                            <li class=" nav-item {{ Route::is('dep_withd')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('dep_withd') }}"><span style="color:{{ Route::is('dep_withd') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">عمليات الاضافة والسحب</span></a></li>
                            <li class=" nav-item {{ Route::is('free_students')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('free_students') }}"><span style="color:{{ Route::is('free_students') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">الطلاب المجانيين</span></a></li>
                        </ul>
                    </li>

              
                @endcan

            
                {{-- <li class=" nav-item {{ Route::is('coupon')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('coupon') }}"><i style="color:{{ Route::is('') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-archway"></i><span style="color:{{ Route::is('accept_user') }}" class="menu-title text-truncate"> الكوبونات</span></a></li> --}}

                @can('الاشعارات')
                    <li class=" nav-item {{ Route::is('notifications')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('notifications') }}"><i style="color:{{ Route::is('notifications') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-bell"></i><span style="color:{{ Route::is('notifications') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate"> الاشعارات</span></a></li>
                @endcan
                 
                @can('سلايدر')
                <li class=" nav-item {{ Route::is('sliders')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('sliders') }}"><i style="color:{{ Route::is('sliders') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-sliders"></i><span style="color:{{ Route::is('sliders') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate"> سلايدر</span></a></li>
                @endcan

                @can("الصفحات الترحيبية")
                    <li class=" nav-item {{ Route::is('onboading')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('onboading') }}"><i style="color:{{ Route::is('onboading') ? '#d2d2d2' : '#656565'}}" class="fa-brands fa-ello"></i><span style="color:{{ Route::is('onboading') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate"> الصفحات الترحيبية</span></a></li>
                @endcan
                
                @can('الدعم')
                    {{-- <li class=" nav-item {{ Route::is('support')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('support') }}"><i style="color:{{ Route::is('') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-archway"></i><span style="color:{{ Route::is('accept_user') }}" class="menu-title text-truncate"> الدعم</span></a></li> --}}
                @endcan

                @can('الاعدادات')
                <li class=" nav-item {{ Route::is('lessons')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('lessons') }}"><i style="color:{{ Route::is('lessons') ? '#d2d2d2' : '#656565'}}"  class="fa-brands fa-usps"></i><span style="color:{{ Route::is('lessons') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate"> نشر الدروس</span></a></li>
                <li class=" nav-item {{ Route::is('setting_dashboard')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('setting_dashboard') }}"><i style="color:{{ Route::is('setting_dashboard') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-wrench"></i><span style="color:{{ Route::is('setting_dashboard') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate"> الاعدادات</span></a></li>
                @endcan

                @can('الصلاحيات')
                    <li class=" nav-item {{ Route::is('vpn_check')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('vpn_check') }}"><i style="color:{{ Route::is('vpn_check') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-network-wired"></i><span style="color:{{ Route::is('vpn_check') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate"> VPN</span></a></li>
                    <li class=" nav-item {{ Route::is('roles.index')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('roles.index') }}"><i style="color:{{ Route::is('roles.index') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-archway"></i><span style="color:{{ Route::is('roles.index') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate"> الصلاحيات</span></a></li>
                @endcan

                @can('فريق النظام')
                    <li class=" nav-item {{ Route::is('admins')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admins') }}"><i style="color:{{ Route::is('admins') ? '#d2d2d2' : '#656565'}}" class="fa-solid fa-user-large-slash"></i><span style="color:{{ Route::is('admins') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate"> المساعدين</span></a></li>
                @endcan

                </ul>
            </div>

      
    </div>
    <!-- END: Main Menu-->