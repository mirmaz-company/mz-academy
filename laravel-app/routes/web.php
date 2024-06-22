<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::get('/image', 'SliderController@resizeImage');


Route::group(['prefix'=>LaravelLocalization::setLocale(),'middleware'=>['auth','admin','localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function(){




    Route::get('/sendNewsletter',               'UserController@sendNewsletter')->name('sendNewsletter');

    Route::get('/my_test_email',               'UserController@my_test_email')->name('my_test_email');

    Route::post('/send_mail',                    'TeacherController@send_mail')->name('send_mail');


    // users
    Route::get('/main_statistic',               'UserController@main_statistic')->name('main_statistic');
    Route::get('/users/{type?}',                'UserController@users')->name('users');


    Route::get('/get_all_users/{type?}',        'UserController@get_all_users')->name('get_all_users');
    Route::get('/users_all',        'UserController@users_all')->name('users_all');
    Route::get('/get_users_all',        'UserController@get_users_all')->name('get_users_all');
    Route::post('/store_users',                 'UserController@add_user_form')->name('store_users');
    Route::post('/update_user',                 'UserController@update_user')->name('update_user');
    Route::post('/destroy_user',                'UserController@destroy_user')->name('destroy_user');
    Route::get('/myprofile',                    'UserController@myprofile')->name('myprofile');
    Route::post('/myprofile_update',            'UserController@myprofile_update')->name('myprofile_update');
    Route::get('/profile_user/{id}',            'UserController@profile_user')->name('profile_user');
    Route::post('/add_accept_user',             'UserController@add_accept_user')->name('add_accept_user');
    Route::post('/add_accept_user_new',         'UserController@add_accept_user_new')->name('add_accept_user_new');
    Route::post('/decline',                     'UserController@decline')->name('decline');
    Route::post('/delte_proxy_user',                     'UserController@deleteProxyUser')->name('delete_proxy_user');
    Route::post('/decline_new',                     'UserController@decline_new')->name('decline_new');
    Route::post('/reset_login',                 'UserController@reset_login')->name('reset_login');
    Route::post('/conver_upload',                 'TeacherController@conver_upload')->name('conver_upload');
    Route::post('/add_money_route',                 'UserController@add_money_route')->name('add_money_route');
    Route::post('/decrease_money_route',                 'UserController@decrease_money_route')->name('decrease_money_route');
    Route::post('/send_noti_pass_route',                 'UserController@send_noti_pass_route')->name('send_noti_pass_route');
    Route::post('/login_to_dashbord',                 'UserController@login_to_dashbord')->name('login_to_dashbord');
    Route::post('/change_sliders',                 'UserController@change_sliders')->name('change_sliders');


    // course_statistics dashboard_tow
    Route::get('/course_statistics/{course_id}',                         'DashboardTwo\CourseAccStatisticsController@course_statistics')->name('course_statistics');
    Route::get('/get_all_course_statistics',                 'DashboardTwo\CourseAccStatisticsController@get_all_course_statistics')->name('get_all_course_statistics');
    Route::get('/get_all_users_courses/{course_id}',                 'DashboardTwo\CourseAccStatisticsController@get_all_users_courses')->name('get_all_users_courses');
    Route::post('/store_course_statistics',                  'DashboardTwo\CourseAccStatisticsController@store_course_statistics')->name('store_course_statistics');
    Route::post('/update_course_statistics',                 'DashboardTwo\CourseAccStatisticsController@update_course_statistics')->name('update_course_statistics');
    Route::post('/destroy_course_statistics',                'DashboardTwo\CourseAccStatisticsController@destroy_course_statistics')->name('destroy_course_statistics');
    Route::post('/update_ratio',                             'DashboardTwo\CourseAccStatisticsController@update_ratio')->name('update_ratio');
    Route::get('/export-excel/{course_id}',                             'DashboardTwo\CourseAccStatisticsController@export_excel')->name('export-excel');
    Route::get('/export-excel_expire/{course_id}',                             'DashboardTwo\CourseAccStatisticsController@export_excel_expire')->name('export-excel_expire');
    Route::get('/export-excel_free/{course_id}',                             'DashboardTwo\CourseAccStatisticsController@export_excel_free')->name('export-excel_free');
    Route::get('/export-excel_free_expire/{course_id}',                             'DashboardTwo\CourseAccStatisticsController@export_excel_free_expire')->name('export-excel_free_expire');


    // course_statistics_expire dashboard_tow
    Route::get('/course_statistics_expire/{course_id}',             'DashboardTwo\CourseAccStatisticsExpireController@course_statistics_expire')->name('course_statistics_expire');
    Route::get('/get_all_course_statistics_expire',                 'DashboardTwo\CourseAccStatisticsExpireController@get_all_course_statistics_expire')->name('get_all_course_statistics_expire');
    Route::get('/get_all_users_courses_expire/{course_id}',                'DashboardTwo\CourseAccStatisticsExpireController@get_all_users_courses_expire')->name('get_all_users_courses_expire');
    Route::post('/store_course_statistics_expire',                  'DashboardTwo\CourseAccStatisticsExpireController@store_course_statistics_expire')->name('store_course_statistics_expire');
    Route::post('/update_course_statistics_expire',                 'DashboardTwo\CourseAccStatisticsExpireController@update_course_statistics_expire')->name('update_course_statistics_expire');
    Route::post('/destroy_course_statistics_expire',                'DashboardTwo\CourseAccStatisticsExpireController@destroy_course_statistics_expire')->name('destroy_course_statistics_expire');


    // all_teachers_se dashboard_tow
    Route::get('/all_teachers_se',                         'DashboardTwo\AllTeacherSeController@all_teachers_se')->name('all_teachers_se');
    Route::get('/get_all_all_teachers_se',                 'DashboardTwo\AllTeacherSeController@get_all_all_teachers_se')->name('get_all_all_teachers_se');
    Route::post('/store_all_teachers_se',                  'DashboardTwo\AllTeacherSeController@store_all_teachers_se')->name('store_all_teachers_se');
    Route::post('/update_all_teachers_se',                 'DashboardTwo\AllTeacherSeController@update_all_teachers_se')->name('update_all_teachers_se');
    Route::post('/destroy_all_teachers_se',                'DashboardTwo\AllTeacherSeController@destroy_all_teachers_se')->name('destroy_all_teachers_se');


    // all_teachers_se dashboard_tow
    Route::get('/wallet_teacher/{teacher_id}',                         'DashboardTwo\WalletTeacherController@wallet_teacher')->name('wallet_teacher');
    Route::get('/get_all_wallet_teacher/{teacher_id}',                 'DashboardTwo\WalletTeacherController@get_all_wallet_teacher')->name('get_all_wallet_teacher');
    Route::post('/store_deposet',                         'DashboardTwo\WalletTeacherController@store_deposet')->name('store_deposet');
    Route::post('/store_withdraw',                         'DashboardTwo\WalletTeacherController@store_withdraw')->name('store_withdraw');
    Route::post('/store_wallet_teacher',                  'DashboardTwo\WalletTeacherController@store_wallet_teacher')->name('store_wallet_teacher');
    Route::post('/update_wallet_teacher',                 'DashboardTwo\WalletTeacherController@update_wallet_teacher')->name('update_wallet_teacher');
    Route::post('/destroy_wallet_teacher',                'DashboardTwo\WalletTeacherController@destroy_wallet_teacher')->name('destroy_wallet_teacher');

    // courses_acc dashboard_tow
    Route::get('/courses_acc/{teacher_id}',                         'DashboardTwo\CourseAccController@courses_acc')->name('courses_acc');
    Route::get('/get_all_courses_acc/{teacher_id}',                 'DashboardTwo\CourseAccController@get_all_courses_acc')->name('get_all_courses_acc');
    Route::post('/store_courses_acc',                  'DashboardTwo\CourseAccController@store_courses_acc')->name('store_courses_acc');
    Route::post('/update_courses_acc',                 'DashboardTwo\CourseAccController@update_courses_acc')->name('update_courses_acc');
    Route::post('/destroy_courses_acc',                'DashboardTwo\CourseAccController@destroy_courses_acc')->name('destroy_courses_acc');



    Route::get('/courses_accept',                         'CourseAcceptController@courses_accept')->name('courses_accept')->middleware(['permission:طلبات الدورات']);
    Route::get('/get_all_courses_accept',                 'CourseAcceptController@get_all_courses_accept')->name('get_all_courses_accept');
    Route::post('/store_courses_accept',                  'CourseAcceptController@store_courses_accept')->name('store_courses_accept');
    Route::post('/update_courses_accept',                 'CourseAcceptController@update_courses_accept')->name('update_courses_accept');
    Route::post('/destroy_courses_accept',                'CourseAcceptController@destroy_courses_accept')->name('destroy_courses_accept');
    Route::post('/accept_this_course',                    'CourseAcceptController@accept_this_course')->name('accept_this_course');
    Route::post('/decline_this_course',                   'CourseAcceptController@decline_this_course')->name('decline_this_course');





    Route::get('/show_password/{ip}',                'UserController@show_password')->name('show_password');
    Route::get('/show_password_loading/{ip}',                'UserController@show_password_loading')->name('show_password_loading');
    Route::post('/show_password_sure',           'UserController@show_password_sure')->name('show_password_sure');

    Route::get('/setting_dashboard',            'SettingController@setting_dashboard')->name('setting_dashboard')->middleware(['permission:الاعدادات']);
    Route::post('/dashboardsetting2',           'SettingController@dashboardsetting2')->name('dashboardsetting2');




    Route::get('/get_all_role',                   'PermissionController@get_all_role')->name('get_all_role');

    Route::get('/export/{id}',                         'UserController@export')->name('export');
    Route::get('/export_course_paid_public/{id}',      'UserController@export_course_paid_public')->name('export_course_paid_public');



    Route::resource('roles', 'RoleController')->middleware(['permission:الصلاحيات']);
    Route::post('/update_rolee',                   'RoleController@update_rolee')->name('update_rolee');
    Route::get('/download-backup',          'RoleController@downloadBackup')->name('download-backup');


    // admins
    Route::get('/admins',                         'AdminController@admins')->name('admins')->middleware(['permission:فريق النظام']);
    Route::get('/get_all_admins',                 'AdminController@get_all_admins')->name('get_all_admins');
    Route::post('/store_admins',                  'AdminController@store_admins')->name('store_admins');
    Route::post('/update_admins',                 'AdminController@update_admins')->name('update_admins');
    Route::post('/destroy_admins',                'AdminController@destroy_admins')->name('destroy_admins');


    // admins
    Route::get('/slider_views/{id}',                         'SliderViewsController@slider_views')->name('slider_views');
    Route::get('/get_all_slider_views/{id}',                 'SliderViewsController@get_all_slider_views')->name('get_all_slider_views');
    Route::post('/store_slider_views',                  'SliderViewsController@store_slider_views')->name('store_slider_views');
    Route::post('/update_slider_views',                 'SliderViewsController@update_slider_views')->name('update_slider_views');
    Route::post('/destroy_slider_views',                'SliderViewsController@destroy_slider_views')->name('destroy_slider_views');


    // dep_withd
    Route::get('/dep_withd',                         'DepoWithdController@dep_withd')->name('dep_withd');
    Route::get('/get_all_dep_withd',                 'DepoWithdController@get_all_dep_withd')->name('get_all_dep_withd');
    Route::post('/store_dep_withd',                  'DepoWithdController@store_dep_withd')->name('store_dep_withd');
    Route::post('/update_dep_withd',                 'DepoWithdController@update_dep_withd')->name('update_dep_withd');
    Route::post('/destroy_dep_withd',                'DepoWithdController@destroy_dep_withd')->name('destroy_dep_withd');


    // free_students
    Route::get('/free_students',                         'FreeStudentController@free_students')->name('free_students');
    Route::get('/get_all_free_students',                 'FreeStudentController@get_all_free_students')->name('get_all_free_students');
    Route::post('/store_free_students',                  'FreeStudentController@store_free_students')->name('store_free_students');
    Route::post('/update_free_students',                 'FreeStudentController@update_free_students')->name('update_free_students');
    Route::post('/destroy_free_students',                'FreeStudentController@destroy_free_students')->name('destroy_free_students');


    // lessons
    Route::get('/lessons',                         'LessonController@lessons')->name('lessons');
    Route::get('/get_all_lessons',                 'LessonController@get_all_lessons')->name('get_all_lessons');
    Route::post('/store_lessons',                  'LessonController@store_lessons')->name('store_lessons');
    Route::post('/update_lessons',                 'LessonController@update_lessons')->name('update_lessons');
    Route::post('/destroy_lessons',                'LessonController@destroy_lessons')->name('destroy_lessons');
    Route::post('/publish_now',                    'LessonController@publish_now')->name('publish_now');



    // support
    Route::get('/support',                         'SupportController@support')->name('support')->middleware(['permission:الدعم']);
    Route::get('/get_all_support',                 'SupportController@get_all_support')->name('get_all_support');



    // cities
    Route::get('/cities',                         'CityController@cities')->name('cities');
    Route::get('/get_all_cities',                 'CityController@get_all_cities')->name('get_all_cities');
    Route::post('/store_cities',                  'CityController@store_cities')->name('store_cities');
    Route::post('/update_cities',                 'CityController@update_cities')->name('update_cities');
    Route::post('/destroy_cities',                'CityController@destroy_cities')->name('destroy_cities');


    // last_used_codes
    Route::get('/last_used_codes',                         'LastUsedCodeController@last_used_codes')->name('last_used_codes');
    Route::get('/get_all_last_used_codes',                 'LastUsedCodeController@get_all_last_used_codes')->name('get_all_last_used_codes');
    Route::post('/store_last_used_codes',                  'LastUsedCodeController@store_last_used_codes')->name('store_last_used_codes');
    Route::post('/update_last_used_codes',                 'LastUsedCodeController@update_last_used_codes')->name('update_last_used_codes');
    Route::post('/destroy_last_used_codes',                'LastUsedCodeController@destroy_last_used_codes')->name('destroy_last_used_codes');


    // add_student_to_course
    Route::get('/add_student_to_course',                         'AddStudentCourseController@add_student_to_course')->name('add_student_to_course');
    Route::get('/get_all_search_courses/{user_id?}',                         'AddStudentCourseController@get_all_search_courses')->name('get_all_search_courses');
    Route::get('/get_all_add_student_to_course',                 'AddStudentCourseController@get_all_add_student_to_course')->name('get_all_add_student_to_course');
    Route::post('/store_add_student_to_course',                  'AddStudentCourseController@store_add_student_to_course')->name('store_add_student_to_course');
    Route::post('/update_add_student_to_course',                 'AddStudentCourseController@update_add_student_to_course')->name('update_add_student_to_course');
    Route::post('/destroy_add_student_to_course',                'AddStudentCourseController@destroy_add_student_to_course')->name('destroy_add_student_to_course');
    Route::post('/add_to_course_route',                'AddStudentCourseController@add_to_course_route')->name('add_to_course_route');
    Route::post('/get_user_info',                'AddStudentCourseController@get_user_info')->name('get_user_info');


    // sale_points
    Route::get('/sale_points/{id}',                         'SalePointsController@sale_points')->name('sale_points');
    Route::get('/get_all_sale_points/{id}',                 'SalePointsController@get_all_sale_points')->name('get_all_sale_points');
    Route::post('/store_sale_points',                  'SalePointsController@store_sale_points')->name('store_sale_points');
    Route::post('/update_sale_points',                 'SalePointsController@update_sale_points')->name('update_sale_points');
    Route::post('/destroy_sale_points',                'SalePointsController@destroy_sale_points')->name('destroy_sale_points');


    // vpn_check
    Route::get('/vpn_check',                         'VpnCheckController@vpn_check')->name('vpn_check');
    Route::get('/get_all_vpn_check',                 'VpnCheckController@get_all_vpn_check')->name('get_all_vpn_check');
    Route::post('/store_vpn_check',                  'VpnCheckController@store_vpn_check')->name('store_vpn_check');
    Route::post('/update_vpn_check',                 'VpnCheckController@update_vpn_check')->name('update_vpn_check');
    Route::post('/destroy_vpn_check',                'VpnCheckController@destroy_vpn_check')->name('destroy_vpn_check');


    // posts
    Route::get('/posts',                         'PostController@posts')->name('posts');
    Route::get('/add_posts',                     'PostController@add_posts')->name('add_posts');
    Route::get('/get_all_posts',                 'PostController@get_all_posts')->name('get_all_posts');
    Route::post('/store_posts',                  'PostController@store_posts')->name('store_posts');
    Route::post('/update_posts',                 'PostController@update_posts')->name('update_posts');
    Route::post('/destroy_posts',                'PostController@destroy_posts')->name('destroy_posts');


    // delivery_card
    Route::get('/delivery_card',                   'DeliveryCardController@delivery_card')->name('delivery_card');
    Route::get('/get_all_delivery_card',           'DeliveryCardController@get_all_delivery_card')->name('get_all_delivery_card');
    Route::post('/store_delivery_card',            'DeliveryCardController@store_delivery_card')->name('store_delivery_card');
    Route::post('/update_delivery_card',           'DeliveryCardController@update_delivery_card')->name('update_delivery_card');
    Route::post('/destroy_delivery_card',          'DeliveryCardController@destroy_delivery_card')->name('destroy_delivery_card');
    Route::post('/accept_price_card',              'DeliveryCardController@accept_price_card')->name('accept_price_card');
    Route::post('/cancel_price_card',              'DeliveryCardController@cancel_price_card')->name('cancel_price_card');
    Route::post('/deny_price_card',                'DeliveryCardController@deny_price_card')->name('deny_price_card');
    Route::post('/delivery_price_card',            'DeliveryCardController@delivery_price_card')->name('delivery_price_card');
    Route::post('/done_price_card',                'DeliveryCardController@done_price_card')->name('done_price_card');


    // purchasescard
    Route::get('/purchasescard',                         'PurchasesCardController@purchasescard')->name('purchasescard');
    Route::get('/get_all_purchasescard',                 'PurchasesCardController@get_all_purchasescard')->name('get_all_purchasescard');
    Route::get('/get_all_purchasescard_price',           'PurchasesCardController@get_all_purchasescard_price')->name('get_all_purchasescard_price');
    Route::post('/store_purchasescard',                  'PurchasesCardController@store_purchasescard')->name('store_purchasescard');
    Route::post('/store_purchasescard_price',            'PurchasesCardController@store_purchasescard_price')->name('store_purchasescard_price');
    Route::post('/update_purchasescard',                 'PurchasesCardController@update_purchasescard')->name('update_purchasescard');
    Route::post('/update_purchasescard_price',           'PurchasesCardController@update_purchasescard_price')->name('update_purchasescard_price');
    Route::post('/destroy_purchasescard',                'PurchasesCardController@destroy_purchasescard')->name('destroy_purchasescard');
    Route::post('/destroy_purchasescard_price',          'PurchasesCardController@destroy_purchasescard_price')->name('destroy_purchasescard_price');


    // form_teacher
    Route::get('/form_teacher',                         'FormTeacherController@form_teacher')->name('form_teacher');
    Route::get('/get_all_form_teacher',                 'FormTeacherController@get_all_form_teacher')->name('get_all_form_teacher');
    Route::post('/store_form_teacher',                  'FormTeacherController@store_form_teacher')->name('store_form_teacher');
    Route::post('/update_form_teacher',                 'FormTeacherController@update_form_teacher')->name('update_form_teacher');
    Route::post('/destroy_form_teacher',                'FormTeacherController@destroy_form_teacher')->name('destroy_form_teacher');


    // ratio_teachers
    Route::get('/ratio_teachers/{id}',                         'RatioTeacherController@ratio_teachers')->name('ratio_teachers');
    Route::get('/get_all_ratio_teachers/{id}',                 'RatioTeacherController@get_all_ratio_teachers')->name('get_all_ratio_teachers');
    Route::post('/store_ratio_teachers',                  'RatioTeacherController@store_ratio_teachers')->name('store_ratio_teachers');
    Route::post('/update_ratio_teachers',                 'RatioTeacherController@update_ratio_teachers')->name('update_ratio_teachers');
    Route::post('/destroy_ratio_teachers',                'RatioTeacherController@destroy_ratio_teachers')->name('destroy_ratio_teachers');


    // onboading
    Route::get('/onboading',                         'OnBoardingController@onboading')->name('onboading');
    Route::get('/get_all_onboading',                 'OnBoardingController@get_all_onboading')->name('get_all_onboading');
    Route::post('/store_onboading',                  'OnBoardingController@store_onboading')->name('store_onboading');
    Route::post('/update_onboading',                 'OnBoardingController@update_onboading')->name('update_onboading');
    Route::post('/destroy_onboading',                'OnBoardingController@destroy_onboading')->name('destroy_onboading');


    // search_codes
    Route::get('/search_codes',                         'SearchCodeController@search_codes')->name('search_codes');
    Route::get('/get_all_search_codes/{code?}',                 'SearchCodeController@get_all_search_codes')->name('get_all_search_codes');
    Route::get('/get_all_search_codes2/{code?}',                 'SearchCodeController@get_all_search_codes2')->name('get_all_search_codes2');
    Route::post('/store_search_codes',                  'SearchCodeController@store_search_codes')->name('store_search_codes');
    Route::post('/update_search_codes',                 'SearchCodeController@update_search_codes')->name('update_search_codes');
    Route::post('/destroy_search_codes',                'SearchCodeController@destroy_search_codes')->name('destroy_search_codes');



    // courses
    Route::get('/courses/{id}',                         'CourseController@courses')->name('courses');
    Route::get('/get_all_courses/{id}',                 'CourseController@get_all_courses')->name('get_all_courses');
    Route::get('/get_all_courses_profile/{id}',         'CourseController@get_all_courses_profile')->name('get_all_courses_profile');
    Route::post('/store_courses',                       'CourseController@store_courses')->name('store_courses');
    Route::post('/cancel_course',                       'CourseController@cancel_course')->name('cancel_course');
    Route::post('/update_courses',                      'CourseController@update_courses')->name('update_courses');
    Route::post('/destroy_courses',                     'CourseController@destroy_courses')->name('destroy_courses');
    Route::post('/update_course_detailes',              'CourseController@update_course_detailes')->name('update_course_detailes');



    // student_are_saying
    Route::get('/student_are_saying',                         'StudentAreSayingController@student_are_saying')->name('student_are_saying');
    Route::get('/get_all_student_are_saying',                 'StudentAreSayingController@get_all_student_are_saying')->name('get_all_student_are_saying');
    Route::post('/store_student_are_saying',                  'StudentAreSayingController@store_student_are_saying')->name('store_student_are_saying');
    Route::post('/update_student_are_saying',                 'StudentAreSayingController@update_student_are_saying')->name('update_student_are_saying');
    Route::post('/destroy_student_are_saying',                'StudentAreSayingController@destroy_student_are_saying')->name('destroy_student_are_saying');
    Route::post('/change_status_student_are_saying',          'StudentAreSayingController@change_status_student_are_saying')->name('change_status_student_are_saying');
    Route::post('/change_status_student_are_saying_forms',          'StudentAreSayingController@change_status_student_are_saying_forms')->name('change_status_student_are_saying_forms');






    // languages
    Route::get('/languages',                         'LanguageController@languages')->name('languages');
    Route::get('/get_all_languages',                 'LanguageController@get_all_languages')->name('get_all_languages');
    Route::post('/store_languages',                  'LanguageController@store_languages')->name('store_languages');
    Route::post('/update_languages',                 'LanguageController@update_languages')->name('update_languages');
    Route::post('/destroy_languages',                'LanguageController@destroy_languages')->name('destroy_languages');


    // wallet_sections
    Route::get('/wallet_sections',                         'WalletSectionController@wallet_sections')->name('wallet_sections')->middleware(['permission:اكواد المحفظة']);
    Route::get('/get_all_wallet_sections',                 'WalletSectionController@get_all_wallet_sections')->name('get_all_wallet_sections');
    Route::post('/store_wallet_sections',                  'WalletSectionController@store_wallet_sections')->name('store_wallet_sections');
    Route::post('/update_wallet_sections',                 'WalletSectionController@update_wallet_sections')->name('update_wallet_sections');
    Route::post('/destroy_wallet_sections',                'WalletSectionController@destroy_wallet_sections')->name('destroy_wallet_sections');





    // recharge_codes_wallet
    Route::get('/recharge_codes/{id}',                    'RechargeController@recharge_codes')->name('recharge_codes');
    Route::get('/get_all_recharge_codes/{id}',            'RechargeController@get_all_recharge_codes')->name('get_all_recharge_codes');
    Route::post('/store_recharge_codes',                  'RechargeController@store_recharge_codes')->name('store_recharge_codes');
    Route::post('/update_recharge_codes',                 'RechargeController@update_recharge_codes')->name('update_recharge_codes');
    Route::post('/destroy_recharge_codes',                'RechargeController@destroy_recharge_codes')->name('destroy_recharge_codes');



    Route::get('/recharge_codes_used/{id}',                    'RechargeController@recharge_codes_used')->name('recharge_codes_used');
    Route::get('/get_all_recharge_codes_used/{id}',            'RechargeController@get_all_recharge_codes_used')->name('get_all_recharge_codes_used');



    // sections_code
    Route::get('/sections_code/{teacher_id}',             'SectionCodeController@sections_code')->name('sections_code');
    Route::get('/get_all_sections_code/{teacher_id}',     'SectionCodeController@get_all_sections_code')->name('get_all_sections_code');
    Route::post('/store_sections_code',                  'SectionCodeController@store_sections_code')->name('store_sections_code');
    Route::post('/update_sections_code',                 'SectionCodeController@update_sections_code')->name('update_sections_code');
    Route::post('/destroy_sections_code',                'SectionCodeController@destroy_sections_code')->name('destroy_sections_code');



    // all_code
    Route::get('/all_code/{id}/{course_id}/{teacher_id}',                         'SectionCodeController@all_code')->name('all_code');
    Route::get('/get_all_all_code/{id}/{course_id}/{teacher_id}',                 'SectionCodeController@get_all_all_code')->name('get_all_all_code');


    // code_used
    Route::get('/code_used/{id}/{course_id}/{teacher_id}',                         'SectionCodeController@code_used')->name('code_used');
    Route::get('/get_all_code_used/{id}/{course_id}/{teacher_id}',                 'SectionCodeController@get_all_code_used')->name('get_all_code_used');



    // accept_user
    Route::get('/accept_user',                         'AcceptUserController@accept_user')->name('accept_user')->middleware(['permission:طلبات الموافقة']);
    Route::get('/get_all_accept_user',                 'AcceptUserController@get_all_accept_user')->name('get_all_accept_user');
    Route::post('/store_accept_user',                  'AcceptUserController@store_accept_user')->name('store_accept_user');
    Route::post('/update_accept_user',                 'AcceptUserController@update_accept_user')->name('update_accept_user');
    Route::post('/destroy_accept_user',                'AcceptUserController@destroy_accept_user')->name('destroy_accept_user');


    // accept_user_new
    Route::get('/accept_user_new',                         'AcceptUserNewController@accept_user_new')->name('accept_user_new')->middleware(['permission:طلبات الموافقة']);
    Route::get('/get_all_accept_user_new',                 'AcceptUserNewController@get_all_accept_user_new')->name('get_all_accept_user_new');
    Route::post('/store_accept_user_new',                  'AcceptUserNewController@store_accept_user_new')->name('store_accept_user_new');
    Route::post('/update_accept_user_new',                 'AcceptUserNewController@update_accept_user_new')->name('update_accept_user_new');
    Route::post('/destroy_accept_user_new',                'AcceptUserNewController@destroy_accept_user_new')->name('destroy_accept_user_new');


    // study
    Route::get('/study',                         'StudyController@study')->name('study');
    Route::get('/get_all_study',                 'StudyController@get_all_study')->name('get_all_study');
    Route::post('/store_study',                  'StudyController@store_study')->name('store_study');
    Route::post('/update_study',                 'StudyController@update_study')->name('update_study');
    Route::post('/destroy_study',                'StudyController@destroy_study')->name('destroy_study');







    // topics
    Route::get('/topics',                         'TopicController@topics')->name('topics');
    Route::get('/get_all_topics',                 'TopicController@get_all_topics')->name('get_all_topics');
    Route::post('/store_topics',                  'TopicController@store_topics')->name('store_topics');
    Route::post('/update_topics',                 'TopicController@update_topics')->name('update_topics');
    Route::post('/destroy_topics',                'TopicController@destroy_topics')->name('destroy_topics');



    // levels
    Route::get('/levels/{id?}',                   'LevelController@levels')->name('levels');
    Route::get('/get_all_levels/{id?}',           'LevelController@get_all_levels')->name('get_all_levels');
    Route::post('/store_levels',                  'LevelController@store_levels')->name('store_levels');
    Route::post('/update_levels',                 'LevelController@update_levels')->name('update_levels');
    Route::post('/destroy_levels',                'LevelController@destroy_levels')->name('destroy_levels');
    Route::get('/get_levels_in_form_add/{id}',        'LevelController@get_levels_in_form_add')->name('get_levels_in_form_add');


    // subjects
    Route::get('/subjects/{id?}',                         'SubjectController@subjects')->name('subjects');
    Route::get('/get_all_subjects/{id?}',                 'SubjectController@get_all_subjects')->name('get_all_subjects');
    Route::post('/store_subjects',                  'SubjectController@store_subjects')->name('store_subjects');
    Route::get('/subject/edit/{id}',                        'SubjectController@edit')->name('edit_subject');
    Route::post('/update_subjects',                 'SubjectController@update_subjects')->name('update_subjects');
    Route::post('/destroy_subjects',                'SubjectController@destroy_subjects')->name('destroy_subjects');


    // teachers
    Route::get('/teachers',                         'TeacherController@teachers')->name('teachers')->middleware(['permission:المعلمين']);
    Route::get('/get_all_teachers',                 'TeacherController@get_all_teachers')->name('get_all_teachers');
    Route::post('/store_teachers',                  'TeacherController@store_teachers')->name('store_teachers');
    Route::post('/update_teachers',                 'TeacherController@update_teachers')->name('update_teachers');
    Route::post('/destroy_teachers',                'TeacherController@destroy_teachers')->name('destroy_teachers');
    Route::post('/is_access',                       'TeacherController@is_access')->name('is_access');
    Route::post('/show_notic',                       'TeacherController@show_notic')->name('show_notic');
    Route::get('/get_levels_from_study/{id}',       'TeacherController@get_levels_from_study')->name('get_levels_from_study');
    Route::get('/get_sujects_from_level/{id}',      'TeacherController@get_sujects_from_level')->name('get_sujects_from_level');
    Route::post('/add_new_subject_to_teacher',      'TeacherController@add_new_subject_to_teacher')->name('add_new_subject_to_teacher');


    Route::post('/create_codes',                'TeacherController@create_codes')->name('create_codes');

    Route::get('/get_courses',                  'TeacherController@get_courses')->name('get_courses');

    // coupon_used
    // Route::get('/coupon_used',                         'CouponUsedController@coupon_used')->name('coupon_used');
    // Route::get('/get_all_coupon_used',                 'CouponUsedController@get_all_coupon_used')->name('get_all_coupon_used');
    // Route::post('/store_coupon_used',                  'CouponUsedController@store_coupon_used')->name('store_coupon_used');
    // Route::post('/update_coupon_used',                 'CouponUsedController@update_coupon_used')->name('update_coupon_used');
    // Route::post('/destroy_coupon_used',                'CouponUsedController@destroy_coupon_used')->name('destroy_coupon_used');


    // copouns
    Route::get('/coupon',                         'CouponController@coupon')->name('coupon');
    Route::get('/get_all_coupon',                 'CouponController@get_all_coupon')->name('get_all_coupon');
    Route::post('/store_coupon',                  'CouponController@store_coupon')->name('store_coupon');
    Route::get('/export_coupon/{id}',             'CouponController@export_coupon')->name('export_coupon');
    Route::post('/update_coupon',                 'CouponController@update_coupon')->name('update_coupon');
    Route::post('/destroy_coupon',                'CouponController@destroy_coupon')->name('destroy_coupon');










    // sliders
    Route::get('/sliders',                         'SliderController@sliders')->name('sliders');
    Route::get('/get_all_sliders',                 'SliderController@get_all_sliders')->name('get_all_sliders');
    Route::post('/store_sliders',                  'SliderController@store_sliders')->name('store_sliders');
    Route::get('/edit_slider/{id}',                 'SliderController@edit_slider')->name('edit_slider');
    Route::post('/update_sliders',                 'SliderController@update_sliders')->name('update_sliders');
    Route::post('/destroy_sliders',                'SliderController@destroy_sliders')->name('destroy_sliders');


    // notifications
    Route::get('/notifications',                         'NotificationController@notifications')->name('notifications')->middleware(['permission:الاشعارات']);
    Route::get('/get_all_notifications',                 'NotificationController@get_all_notifications')->name('get_all_notifications');
    Route::post('/send_notification_to_person',          'NotificationController@send_notification_to_person')->name('send_notification_to_person');
    Route::post('/send_notification_to_all',             'NotificationController@send_notification_to_all')->name('send_notification_to_all');
    // Route::post('/store_notifications',                  'CityController@store_notifications')->name('store_notifications');
    // Route::post('/update_notifications',                 'CityController@update_notifications')->name('update_notifications');
    // Route::post('/destroy_notifications',                'CityController@destroy_notifications')->name('destroy_notifications');

    Route::get('/get_levels_in_form_add/{id}',        'LevelController@get_levels_in_form_add')->name('get_levels_in_form_add');
    Route::get('/get_subjects_in_form_add/{id}',        'LevelController@get_subjects_in_form_add')->name('get_subjects_in_form_add');

});

Route::get('',                'UserController@users_redirect')->middleware('auth');

//  Auth::routes();

Route::get('/login',          'Auth\LoginController@loginForm')->name('login.show');
Route::get('/login/{type}',   'Auth\LoginController@loginForm')->name('login.show');
Route::post('/login',         'Auth\LoginController@login')->name('login');
Route::post('/logout/{type}', 'Auth\LoginController@logout')->name('logout');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/upload_youtube',                   'StudyController@upload_youtube')->name('upload_youtube');


Route::get('/mirmaz_teacher_form',            'SliderController@mirmaz_teacher_form')->name('mirmaz_teacher_form');

Route::post('/form_teacher',                'TeacherController@form_teacher')->name('form_teacher');
Route::post('/generate_pdf',            'TeacherController@generate_pdf')->name('generate_pdf');
Route::get('/generate_pdf_admin/{id}',            'TeacherController@generate_pdf_admin')->name('generate_pdf_admin');
Route::get('/book_pdf',                        'TeacherController@book_pdf')->name('book_pdf');

Route::get('/clear', function() {
    $exitCode = Artisan::call('optimize:clear');
    return 'what you want';
});


