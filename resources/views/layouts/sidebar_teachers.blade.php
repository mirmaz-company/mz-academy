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
                  

                {{-- تم عمل لون الخط والفونت اوسم في الاحصائيات والطلاب المشتركين..يجب عملهم على الكل في السايدبار تبع المعلم والادمن --}}
                @can("الاحصائيات")
                    <li class=" nav-item {{ url()->current() == asset("/ar/teachers/statistics") ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('teachers.statistics') }}"><i class="fa fa-home" style="color:{{ url()->current() == asset("/ar/teachers/statistics") ? '#d2d2d2' : '#656565'}}"></i><span  style="color:{{ url()->current() == asset("/ar/teachers/statistics") ? '#d2d2d2' : '#656565'}}"  class="menu-title text-truncate"> الاحصائيات </span></a></li>
                    @endcan

                    @can("الطلاب المشتركين")
                    <li class=" nav-item {{ url()->current() == asset("/ar/teachers/users/active") ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('users') }}"><i class="fa fa-users" style="color:{{ url()->current() == asset("/ar/teachers/users/active") ? '#d2d2d2' : '#656565'}}"></i><span style="color:{{ url()->current() == asset("/ar/teachers/users/active") ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate">الطلاب المشتركين </span></a></li>
                    @endcan
                  
                    @can("الدورات")
                         <li class=" nav-item {{ Route::is('teachers.courses')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('teachers.courses') }}"><i class="fa-solid fa-chalkboard" style="color:{{ Route::is('teachers.courses') ? '#d2d2d2' : '#656565'}}"></i><span style="color:{{ Route::is('teachers.courses') ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate"> الدورات </span></a></li>
                    @endcan

                    @can("الفصول")
                         <li class=" nav-item {{ Route::is('teachers.sections')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('teachers.sections') }}"><i class="fa-solid fa-layer-group" style="color:{{ Route::is('teachers.sections') ? '#d2d2d2' : '#656565'}}"></i><span style="color:{{ Route::is('teachers.sections') ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate"> الفصول </span></a></li>
                    @endcan

                    @can("الدروس")
                        <li class=" nav-item {{ Route::is('teachers.lessons')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('teachers.lessons') }}"><i class="fa-solid fa-file-signature" style="color:{{ Route::is('teachers.lessons') ? '#d2d2d2' : '#656565'}}"></i><span style="color:{{ Route::is('teachers.lessons') ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate"> الدروس </span></a></li>
                   
                    @endcan
                        
                    @can("المتابعين")
                        <li class=" nav-item {{ Route::is('teachers.follwers')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('teachers.follwers') }}"><i class="fa-brands fa-twitter" style="color:{{ Route::is('teachers.follwers') ? '#d2d2d2' : '#656565'}}"></i><span style="color:{{ Route::is('teachers.follwers') ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate"> المتابعين </span></a></li>
                        @endcan


                        @can("تقييمات الاساتذة")
                        <li class=" nav-item {{ Route::is('teachers.rate_teachers')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('teachers.rate_teachers') }}"><i class="fa fa-star" style="color:{{ Route::is('teachers.rate_teachers') ? '#d2d2d2' : '#656565'}}"></i><span style="color:{{ Route::is('teachers.rate_teachers') ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate"> تقييمات الاستاذ </span></a></li>
                        @endcan


                        @can("كل التعليقات")
                        <li class=" nav-item {{ Route::is('teachers.all_comments')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('teachers.all_comments') }}"><i class="fa-solid fa-comment" style="color:{{ Route::is('teachers.all_comments') ? '#d2d2d2' : '#656565'}}"></i><span style="color:{{ Route::is('teachers.all_comments') ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate">كل التعليقات</span></a></li>
                        @endcan
            
                        @can("اعدادات الحساب")
                         <li class=" nav-item {{ Route::is('teachers.settings_teacher')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('teachers.settings_teacher') }}"><i class="fa-solid fa-gear" style="color:{{ Route::is('teachers.settings_teacher') ? '#d2d2d2' : '#656565'}}"></i><span style="color:{{ Route::is('teachers.settings_teacher') ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate"> اعدادات الحساب </span></a></li>
                         @endcan

                         @can('المنشورات')
                             <li class=" nav-item {{ Route::is('teachers.all_posts')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('teachers.all_posts') }}"><i class="fa-solid fa-blog" style="color:{{ Route::is('teachers.all_posts') ? '#d2d2d2' : '#656565'}}"></i><span style="color:{{ Route::is('teachers.all_posts') ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate"> المنشورات </span></a></li>
                         @endcan
                         @can("الصلاحيات")
                         <li class=" nav-item {{ Route::is('teachers.roles.index')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('teachers.roles.index') }}"><i class="fa-solid fa-archway" style="color:{{ Route::is('teachers.roles.index') ? '#d2d2d2' : '#656565'}}"></i><span style="color:{{ Route::is('teachers.roles.index') ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate"> الصلاحيات</span></a></li>
                         @endcan

                         @can("فريق النظام")
                         <li class=" nav-item {{ Route::is('teachers.admins')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('teachers.admins') }}"><i class="fa-solid fa-user-large-slash" style="color:{{ Route::is('teachers.admins') ? '#d2d2d2' : '#656565'}}"></i><span style="color:{{ Route::is('teachers.admins') ? '#d2d2d2' : '#656565'}}" class="menu-title text-truncate"> المساعدين</span></a></li>
                 
                         @endcan
                </ul>
            </div>

    </div>
    <!-- END: Main Menu-->