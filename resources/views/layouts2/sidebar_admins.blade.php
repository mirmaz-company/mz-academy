
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

                 
                    <li class=" nav-item {{ Route::is('all_teachers_se')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('all_teachers_se') }}"><i style="color:{{ Route::is('all_teachers_se') ? '#d2d2d2' : '#656565'}}" class="fa-solid chalkboard"></i><span style="color:{{ Route::is('all_teachers_se') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">المدرسين</span></a></li>
                  
                   
             

                </ul>
            </div>

      
    </div>
    <!-- END: Main Menu-->