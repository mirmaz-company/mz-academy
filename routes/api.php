<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;




Route::post('/register',              '\App\Http\Controllers\Api\AuthController@register');
Route::post('/register_tow',              '\App\Http\Controllers\Api\AuthController@register_tow');
Route::post('/login',                 '\App\Http\Controllers\Api\AuthController@login');
Route::post('/forget_password',       '\App\Http\Controllers\Api\AuthController@forget_password');
Route::post('/verify_account',        '\App\Http\Controllers\Api\AuthController@verify_account');
Route::post('/reset_password',       '\App\Http\Controllers\Api\AuthController@reset_password');
Route::post('/update_password',      '\App\Http\Controllers\Api\AuthController@update_password');
Route::post('/check_code_forget_password',       '\App\Http\Controllers\Api\AuthController@check_code_forget_password');
Route::post('/check_mobile_code',       '\App\Http\Controllers\Api\AuthController@check_mobile_code');
Route::post('/login_social',            '\App\Http\Controllers\Api\AuthController@login_social');
Route::post('/register_social',         '\App\Http\Controllers\Api\AuthController@register_social');
Route::post('/logout',                  '\App\Http\Controllers\Api\AuthController@logout');
Route::post('/check_is_mobile',        '\App\Http\Controllers\Api\AuthController@check_is_mobile');
Route::post('/check_if_the_same_device',        '\App\Http\Controllers\Api\AuthController@check_if_the_same_device');
Route::post('/add_new_password',        '\App\Http\Controllers\Api\AuthController@add_new_password');

Route::get('/get_lang',               '\App\Http\Controllers\Api\UserController@get_lang');


Route::get('/get_lang_test',               '\App\Http\Controllers\Api\UserController@get_lang_test');
Route::get('/ios_app_version',               '\App\Http\Controllers\Api\UserController@get_ios_version');



Route::post('/send_proxy',               '\App\Http\Controllers\Api\UserController@send_proxy');



Route::get('/get_sliders',       '\App\Http\Controllers\Api\SliderController@get_sliders');
Route::post('/slider_view',       '\App\Http\Controllers\Api\SliderController@slider_view');


Route::post('/add_comment',        '\App\Http\Controllers\Api\CommentController@add_comment');
Route::post('/get_all_comments',   '\App\Http\Controllers\Api\CommentController@get_all_comments');
Route::post('/add_reply',          '\App\Http\Controllers\Api\CommentController@add_reply');
Route::post('/get_reply',          '\App\Http\Controllers\Api\CommentController@get_reply');
Route::post('/add_like_comment',   '\App\Http\Controllers\Api\CommentController@add_like_comment');


Route::post('/book_mark',   '\App\Http\Controllers\Api\CourseController@book_mark');
Route::get('/get_all_courses_book_mark',   '\App\Http\Controllers\Api\CourseController@get_all_courses_book_mark');



Route::post('/get_profile_by_id',      '\App\Http\Controllers\Api\UserController@get_profile_by_id')->middleware('auth:api');
Route::post('/change_phone_number',      '\App\Http\Controllers\Api\UserController@change_phone_number')->middleware('auth:api');

Route::get('/my_profile',              '\App\Http\Controllers\Api\UserController@my_profile')->middleware('auth:api');
Route::post('/update_profile',         '\App\Http\Controllers\Api\UserController@update_profile')->middleware('auth:api');
Route::post('/change_photo',         '\App\Http\Controllers\Api\UserController@change_photo')->middleware('auth:api');

Route::post('/add_student_are_saying',         '\App\Http\Controllers\Api\UserController@add_student_are_saying')->middleware('auth:api');
Route::get('/student_are_saying',         '\App\Http\Controllers\Api\UserController@student_are_saying');
Route::get('/student_are_saying_see_all',         '\App\Http\Controllers\Api\UserController@student_are_saying_see_all');
Route::post('/study_level',         '\App\Http\Controllers\Api\UserController@study_level');


Route::get('/popular',               '\App\Http\Controllers\Api\HomeController@popular');
Route::post('/cities_sale_points',               '\App\Http\Controllers\Api\HomeController@cities_sale_points');
Route::post('/support_website',               '\App\Http\Controllers\Api\HomeController@support_website');
Route::get('/most_rated',            '\App\Http\Controllers\Api\HomeController@most_rated');
Route::get('/new_product',           '\App\Http\Controllers\Api\HomeController@new_product');
Route::post('/filter',               '\App\Http\Controllers\Api\HomeController@filter');
Route::get('/all_level',             '\App\Http\Controllers\Api\HomeController@all_level');
Route::get('/all_study',             '\App\Http\Controllers\Api\HomeController@all_study');
Route::get('/all_topic',             '\App\Http\Controllers\Api\HomeController@all_topic');
Route::get('/most_important',             '\App\Http\Controllers\Api\HomeController@most_important');
Route::post('/update_lesson_server',             '\App\Http\Controllers\Api\HomeController@update_lesson_server');

Route::post('/edit_topics',          '\App\Http\Controllers\Api\UserController@edit_topics');
Route::get('/my_topics',             '\App\Http\Controllers\Api\UserController@my_topics');

Route::post('/edit_study_level',     '\App\Http\Controllers\Api\UserController@edit_study_level');

Route::get('/all_categories',        '\App\Http\Controllers\Api\HomeController@all_categories');
Route::get('/onboarding',            '\App\Http\Controllers\Api\HomeController@onboarding');
Route::post('/top_students',            '\App\Http\Controllers\Api\HomeController@top_students');



Route::get('/my_wallet',             '\App\Http\Controllers\Api\WalletController@my_wallet');
Route::post('/add_image',             '\App\Http\Controllers\Api\WalletController@add_image');
Route::get('/my_billings',           '\App\Http\Controllers\Api\WalletController@my_billings');
Route::post('/reachange_wallet',     '\App\Http\Controllers\Api\WalletController@reachange_wallet');



Route::post('/test_coupon',             '\App\Http\Controllers\Api\CouponController@test_coupon');




Route::post('/quiz_detailes',               '\App\Http\Controllers\Api\QuizController@quiz_detailes');
Route::post('/quiz_qustions_and_answers',   '\App\Http\Controllers\Api\QuizController@quiz_qustions_and_answers');
Route::post('/end_quiz',                    '\App\Http\Controllers\Api\QuizController@end_quiz');
Route::post('/get_answers_quiz',                    '\App\Http\Controllers\Api\QuizController@get_answers_quiz');
Route::post('/start_quiz',                  '\App\Http\Controllers\Api\QuizController@start_quiz');






Route::get('/recomende_coruses',                   '\App\Http\Controllers\Api\CourseController@recomende_coruses');
Route::get('/check_verifcations',                  '\App\Http\Controllers\Api\CourseController@check_verifcations');
Route::get('/see_all_recomende_coruses',           '\App\Http\Controllers\Api\CourseController@see_all_recomende_coruses');
Route::get('/on_sale_course_home',                 '\App\Http\Controllers\Api\CourseController@on_sale_course_home');
Route::get('/see_all_on_sale_course_home',         '\App\Http\Controllers\Api\CourseController@see_all_on_sale_course_home');
Route::get('/best_courses_home',                   '\App\Http\Controllers\Api\CourseController@best_courses_home');
Route::get('/see_all_best_courses_home',           '\App\Http\Controllers\Api\CourseController@see_all_best_courses_home');
Route::get('/popular_courses',                     '\App\Http\Controllers\Api\CourseController@popular_courses');

Route::get('/recent_courses',                      '\App\Http\Controllers\Api\CourseController@recent_courses');
Route::get('/courses_favorites',                   '\App\Http\Controllers\Api\CourseController@courses_favorites');
Route::get('/my_course',                           '\App\Http\Controllers\Api\CourseController@my_course');
Route::get('/courses_in_progress',                 '\App\Http\Controllers\Api\CourseController@courses_in_progress');
Route::get('/courses_complete',                    '\App\Http\Controllers\Api\CourseController@courses_complete');
Route::post('/like_or_remove_like_course',         '\App\Http\Controllers\Api\CourseController@like_or_remove_like_course');
Route::post('/lesson_by_id',                       '\App\Http\Controllers\Api\CourseController@lesson_by_id');
Route::post('/lesson_by_id_new',                       '\App\Http\Controllers\Api\CourseController@lesson_by_id_new');
Route::post('/lesson_files',                       '\App\Http\Controllers\Api\CourseController@lesson_files');


Route::post('/popular_course_subject_id',                 '\App\Http\Controllers\Api\CourseController@popular_course_subject_id');
Route::post('/see_all_popular_course_subject_id',         '\App\Http\Controllers\Api\CourseController@see_all_popular_course_subject_id');

Route::post('/new_courses_subject_id',                 '\App\Http\Controllers\Api\CourseController@new_courses_subject_id');
Route::post('/see_all_new_courses_subject_id',         '\App\Http\Controllers\Api\CourseController@see_all_new_courses_subject_id');


Route::post('/recomende_coruses_subject_id',                 '\App\Http\Controllers\Api\CourseController@recomende_coruses_subject_id');
Route::post('/see_all_recomende_coruses_subject_id',         '\App\Http\Controllers\Api\CourseController@see_all_recomende_coruses_subject_id');




Route::post('/course_over_view',                   '\App\Http\Controllers\Api\CourseController@course_over_view');
Route::post('/course_lessons',                     '\App\Http\Controllers\Api\CourseController@course_lessons');
Route::post('/course_sections',                     '\App\Http\Controllers\Api\CourseController@course_sections');
Route::post('/course_lessons_by_section',                     '\App\Http\Controllers\Api\CourseController@course_lessons_by_section');
Route::post('/course_lessons_new',                     '\App\Http\Controllers\Api\CourseController@course_lessons_new');
Route::post('/add_course_reviews',                 '\App\Http\Controllers\Api\CourseController@add_course_reviews');
Route::post('/all_reviews_courses',                '\App\Http\Controllers\Api\CourseController@all_reviews_courses');
Route::post('/send_progress_lesson',               '\App\Http\Controllers\Api\CourseController@send_progress_lesson');
Route::post('/subscripe_course',                   '\App\Http\Controllers\Api\CourseController@subscripe_course');
Route::post('/subscripe_course_new',                   '\App\Http\Controllers\Api\CourseController@subscripe_course_new');
Route::post('/send_verified_data',                 '\App\Http\Controllers\Api\CourseController@send_verified_data');
Route::post('/send_verified_data_new',             '\App\Http\Controllers\Api\CourseController@send_verified_data_new');
Route::post('/search',                             '\App\Http\Controllers\Api\CourseController@search');

Route::post('/best_courses_subject_id',                '\App\Http\Controllers\Api\CourseController@best_courses_subject_id');
Route::post('/see_all_best_courses_subject_id',        '\App\Http\Controllers\Api\CourseController@see_all_best_courses_subject_id');


 
Route::get('/get_subjects',                      '\App\Http\Controllers\Api\SubjetController@get_subjects');
Route::get('/get_all_subjects',                  '\App\Http\Controllers\Api\SubjetController@get_all_subjects');
Route::post('/subject_name',                     '\App\Http\Controllers\Api\SubjetController@subject_name');
Route::post('/see_all_best_course_for_subject',  '\App\Http\Controllers\Api\SubjetController@see_all_best_course_for_subject');
Route::post('/see_all_new_course_for_subject',   '\App\Http\Controllers\Api\SubjetController@see_all_new_course_for_subject');
Route::post('/search_subjects',                   '\App\Http\Controllers\Api\SubjetController@search_subjects');


Route::post('/teacher_profile',                       '\App\Http\Controllers\Api\TeacherController@teacher_profile');
Route::get('/best_teacher_home',                      '\App\Http\Controllers\Api\TeacherController@best_teacher_home');
Route::get('/see_all_best_teacher_home',              '\App\Http\Controllers\Api\TeacherController@see_all_best_teacher_home');
Route::post('/best_teacher_subject_id',               '\App\Http\Controllers\Api\TeacherController@best_teacher_subject_id');
Route::post('/see_all_best_teacher_by_subject_id',    '\App\Http\Controllers\Api\TeacherController@see_all_best_teacher_by_subject_id');



Route::get('/get_purchase',                           '\App\Http\Controllers\Api\PurchaesCotnroller@get_purchase');
Route::post('/add_purchase_order_card',               '\App\Http\Controllers\Api\PurchaesCotnroller@add_purchase_order_card');

Route::post('/check_mac',        '\App\Http\Controllers\Api\AuthController@check_mac');



Route::get('/popular_teacher_home',                   '\App\Http\Controllers\Api\TeacherController@popular_teacher_home');
Route::get('/see_all_popular_teacher_home',           '\App\Http\Controllers\Api\TeacherController@see_all_popular_teacher_home');
Route::post('/popular_teacher_subject_id',            '\App\Http\Controllers\Api\TeacherController@popular_teacher_subject_id');
Route::post('/see_all_popular_teacher_subject_id',    '\App\Http\Controllers\Api\TeacherController@see_all_popular_teacher_subject_id');
Route::post('/courses_teachers',                      '\App\Http\Controllers\Api\TeacherController@courses_teachers');
Route::post('/reviews_teacher',                      '\App\Http\Controllers\Api\TeacherController@reviews_teacher');



Route::post('/see_all_new_teacher',                   '\App\Http\Controllers\Api\TeacherController@see_all_new_teacher');
Route::post('/add_review_teacher',                    '\App\Http\Controllers\Api\TeacherController@add_review_teacher');
Route::post('/all_teachers',                          '\App\Http\Controllers\Api\TeacherController@all_teachers');
Route::post('/follow_teacher',                        '\App\Http\Controllers\Api\TeacherController@follow_teacher');


Route::get('/all_notification',                '\App\Http\Controllers\Api\NotificationController@all_notification')->middleware('auth:api');
Route::get('/all_notification_new',                '\App\Http\Controllers\Api\NotificationController@all_notification_new')->middleware('auth:api');
Route::post('/read_notification',              '\App\Http\Controllers\Api\NotificationController@read_notification')->middleware('auth:api');
Route::post('/read_notification_for_all',      '\App\Http\Controllers\Api\NotificationController@read_notification_for_all')->middleware('auth:api');
Route::post('/delete_notifications',           '\App\Http\Controllers\Api\NotificationController@delete_notifications')->middleware('auth:api');

Route::get('/check_api',                       '\App\Http\Controllers\Api\UserController@check_api');



// Route::get('/get_categories',         '\App\Http\Controllers\Api\UserController@get_categories')->middleware('auth:api');

Route::get('/home',                   '\App\Http\Controllers\Api\UserController@home')->middleware('auth:api');
Route::get('/cities',                 '\App\Http\Controllers\Api\UserController@cities');
Route::post('/vpn_check',             '\App\Http\Controllers\Api\UserController@vpn_check');
Route::post('/installed_apps',        '\App\Http\Controllers\Api\UserController@installed_apps');



Route::get('/get_categories',                 '\App\Http\Controllers\Api\UserController@get_categories');


Route::get('/get_settings',                 '\App\Http\Controllers\Api\UserController@get_settings');


Route::post('/support',                   '\App\Http\Controllers\Api\UserController@support')->middleware('auth:api');

Route::get('/get_posts',                    '\App\Http\Controllers\Api\PostController@get_posts');
Route::post('/add_like_to_post',            '\App\Http\Controllers\Api\PostController@add_like_to_post');
Route::post('/add_comment_post',                 '\App\Http\Controllers\Api\PostController@add_comment');
Route::post('/delete_comment',              '\App\Http\Controllers\Api\PostController@delete_comment');
Route::post('/increase_count_share',        '\App\Http\Controllers\Api\PostController@increase_count_share');
Route::post('/add_like_comment_post',            '\App\Http\Controllers\Api\PostController@add_like_comment');
Route::post('/all_comments',                '\App\Http\Controllers\Api\PostController@all_comments');
Route::post('/add_reply_post',                   '\App\Http\Controllers\Api\PostController@add_reply');
Route::post('/all_reply',                   '\App\Http\Controllers\Api\PostController@all_reply');
Route::post('/get_post_by_id',               '\App\Http\Controllers\Api\PostController@get_post_by_id');
Route::post('/get_posts_teacher',               '\App\Http\Controllers\Api\PostController@get_posts_teacher');



Route::post('/add_favorite',              '\App\Http\Controllers\Api\UserController@add_favorite')->middleware('auth:api');
Route::post('/remove_favorite',           '\App\Http\Controllers\Api\UserController@remove_favorite')->middleware('auth:api');
Route::get('/list_favorite',              '\App\Http\Controllers\Api\UserController@list_favorite')->middleware('auth:api');
Route::post('/send_support',              '\App\Http\Controllers\Api\UserController@send_support')->middleware('auth:api');





Route::post('/classification_by_cities',   '\App\Http\Controllers\Api\UserController@classification_by_cities')->middleware('auth:api');