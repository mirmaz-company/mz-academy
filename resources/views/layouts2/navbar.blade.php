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
        <ul class="nav navbar-nav align-items-center ml-auto" style="position: relative;left: 37%;">

           
            
            {{-- <li class="nav-item dropdown dropdown-language"><a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-{{ LaravelLocalization::getCurrentLocale() == "ar" ? "jo" :"us" }}"></i><span class="selected-language">{{ LaravelLocalization::getCurrentLocale() }}</span></a>
                
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    
                            <a rel="alternate" class="dropdown-item" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                               
                                 {{ $properties['native'] }}</a>
                            </a>
                    
                    @endforeach
                </div>
            </li> --}}

      
            <div>
                <h1 style="color: green;font-family: 'Cairo', sans-serif;font-family: 'Noto Sans Arabic', sans-serif;">الاحصائيات المالية (أكاديمية مرماز)</h1>
            </div>
        </ul>
    </div>
</nav>