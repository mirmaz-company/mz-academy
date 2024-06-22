<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



Route::group(['prefix'=>LaravelLocalization::setLocale().'/teachers/','as'=>'teachers.','middleware'=>['auth:teachers','localeSessionRedirect','is_access','is_complete', 'localizationRedirect', 'localeViewPath']], function(){


     // users
     Route::get('/users/active/{id?}',                'Teachers\UserController@users')->name('users');
     Route::get('/get_all_users/{id?}',                'Teachers\UserController@get_all_users')->name('get_all_users');
     Route::post('/store_users',                 'Teachers\UserController@add_user_form')->name('store_users');
     Route::post('/update_user',                 'Teachers\UserController@update_user')->name('update_user');
     Route::post('/destroy_user',                'Teachers\UserController@destroy_user')->name('destroy_user');
     Route::get('/myprofile',                    'Teachers\UserController@myprofile')->name('myprofile');
     Route::post('/myprofile_update',            'Teachers\UserController@myprofile_update')->name('myprofile_update');
     Route::get('/profile_user/{id}',            'Teachers\UserController@profile_user')->name('profile_user');

        // comments
    Route::get('/all_comments',                         'Teachers\CommentAllController@all_comments')->name('all_comments')->middleware(['permission:كل التعليقات']);
    Route::get('/get_all_all_comments',                 'Teachers\CommentAllController@get_all_all_comments')->name('get_all_all_comments');
    Route::post('/store_all_comments',                  'Teachers\CommentAllController@store_all_comments')->name('store_all_comments');
    Route::post('/update_all_comments',                 'Teachers\CommentAllController@update_all_comments')->name('update_all_comments');
    Route::post('/destroy_all_comments',                'Teachers\CommentAllController@destroy_all_comments')->name('destroy_all_comments');
    
    Route::get('/get_sujects_from_level/{id}',      'TeacherController@get_sujects_from_level')->name('get_sujects_from_level');
    
    Route::post('/is_view',      'Teachers\QuizController@is_view')->name('is_view');
    
    Route::post('/send_notification_to_supscribers',          'Teachers\CommentAllController@send_notification_to_supscribers')->name('send_notification_to_supscribers');
    Route::post('/send_notification_to_supscribers_quiz',          'Teachers\CommentAllController@send_notification_to_supscribers_quiz')->name('send_notification_to_supscribers_quiz');


    // quiz_students
    Route::get('/quiz_students/{id}/{type}',                       'Teachers\QuizStudentsController@quiz_students')->name('quiz_students');
    Route::get('/get_all_quiz_students/{id}/{type}',               'Teachers\QuizStudentsController@get_all_quiz_students')->name('get_all_quiz_students');
    Route::post('/store_quiz_students',                'Teachers\QuizStudentsController@store_quiz_students')->name('store_quiz_students');
    Route::post('/update_quiz_students',               'Teachers\QuizStudentsController@update_quiz_students')->name('update_quiz_students');
    Route::post('/destroy_quiz_students',              'Teachers\QuizStudentsController@destroy_quiz_students')->name('destroy_quiz_students');



    // cities
    Route::get('/cities',                       'Teachers\CityController@cities')->name('cities');
    Route::get('/get_all_cities',               'Teachers\CityController@get_all_cities')->name('get_all_cities');
    Route::post('/store_cities',                'Teachers\CityController@store_cities')->name('store_cities');
    Route::post('/update_cities',               'Teachers\CityController@update_cities')->name('update_cities');
    Route::post('/destroy_cities',              'Teachers\CityController@destroy_cities')->name('destroy_cities');


    // answers_quiz
    Route::get('/answers_quiz/{quiz_id}',                       'Teachers\AnswerQuizController@answers_quiz')->name('answers_quiz');
    Route::get('/get_all_answers_quiz/{quiz_id}',               'Teachers\AnswerQuizController@get_all_answers_quiz')->name('get_all_answers_quiz');
    Route::post('/store_answers_quiz',                'Teachers\AnswerQuizController@store_answers_quiz')->name('store_answers_quiz');
    Route::post('/update_answers_quiz',               'Teachers\AnswerQuizController@update_answers_quiz')->name('update_answers_quiz');
    Route::post('/destroy_answers_quiz',              'Teachers\AnswerQuizController@destroy_answers_quiz')->name('destroy_answers_quiz');


    // quiz_students_show
    Route::get('/quiz_students_show/{quiz_id}/{user_id}',   'Teachers\QuizStudentShowController@quiz_students_show')->name('quiz_students_show');
    Route::get('/get_all_quiz_students_show/{quiz_id}/{user_id}',               'Teachers\QuizStudentShowController@get_all_quiz_students_show')->name('get_all_quiz_students_show');
    Route::get('/get_all_quiz_students_show_images/{quiz_id}/{user_id}',               'Teachers\QuizStudentShowController@get_all_quiz_students_show_images')->name('get_all_quiz_students_show_images');
    Route::post('/store_quiz_students_show',                'Teachers\QuizStudentShowController@store_quiz_students_show')->name('store_quiz_students_show');
    Route::post('/update_quiz_students_show',               'Teachers\QuizStudentShowController@update_quiz_students_show')->name('update_quiz_students_show');
    Route::post('/destroy_quiz_students_show',              'Teachers\QuizStudentShowController@destroy_quiz_students_show')->name('destroy_quiz_students_show');






    // posts
    Route::get('/posts',                       'Teachers\PostController@posts')->name('posts');
    Route::get('/all_posts',                    'Teachers\PostController@all_posts')->name('all_posts');
    Route::get('/get_all_posts',               'Teachers\PostController@get_all_posts')->name('get_all_posts');
    Route::post('/store_posts',                'Teachers\PostController@store_posts')->name('store_posts');
    Route::post('/update_posts',               'Teachers\PostController@update_posts')->name('update_posts');
    Route::post('/destroy_posts',              'Teachers\PostController@destroy_posts')->name('destroy_posts');


    // quiz_answers
    Route::get('/quiz_answers/{id}',                       'Teachers\QuizAnswerController@quiz_answers')->name('quiz_answers');
    Route::get('/get_all_quiz_answers/{id}',               'Teachers\QuizAnswerController@get_all_quiz_answers')->name('get_all_quiz_answers');
    Route::post('/store_quiz_answers',                'Teachers\QuizAnswerController@store_quiz_answers')->name('store_quiz_answers');
    Route::post('/update_quiz_answers',               'Teachers\QuizAnswerController@update_quiz_answers')->name('update_quiz_answers');
    Route::post('/destroy_quiz_answers',              'Teachers\QuizAnswerController@destroy_quiz_answers')->name('destroy_quiz_answers');


    // quiz_qustions
    Route::get('/quiz_qustions/{id}/{type}',                       'Teachers\QuizQustionController@quiz_qustions')->name('quiz_qustions');
    Route::get('/get_all_quiz_qustions/{id}',               'Teachers\QuizQustionController@get_all_quiz_qustions')->name('get_all_quiz_qustions');
    Route::post('/store_quiz_qustions',                'Teachers\QuizQustionController@store_quiz_qustions')->name('store_quiz_qustions');
    Route::post('/update_quiz_qustions',               'Teachers\QuizQustionController@update_quiz_qustions')->name('update_quiz_qustions');
    Route::post('/destroy_quiz_qustions',              'Teachers\QuizQustionController@destroy_quiz_qustions')->name('destroy_quiz_qustions');


    // quiz
    Route::get('/quiz/{id}',                       'Teachers\QuizController@quiz')->name('quiz');
    Route::get('/get_all_quiz/{id}',               'Teachers\QuizController@get_all_quiz')->name('get_all_quiz');
    Route::post('/store_quiz',                'Teachers\QuizController@store_quiz')->name('store_quiz');
    Route::post('/update_quiz',               'Teachers\QuizController@update_quiz')->name('update_quiz');
    Route::post('/destroy_quiz',              'Teachers\QuizController@destroy_quiz')->name('destroy_quiz');


     // rate_teachers
     Route::get('/rate_teachers',                       'Teachers\RateTeacherController@rate_teachers')->name('rate_teachers')->middleware(['permission:تقييمات الاساتذة']);
     Route::get('/get_all_rate_teachers',               'Teachers\RateTeacherController@get_all_rate_teachers')->name('get_all_rate_teachers');
     Route::post('/store_rate_teachers',                'Teachers\RateTeacherController@store_rate_teachers')->name('store_rate_teachers');
     Route::post('/update_rate_teachers',               'Teachers\RateTeacherController@update_rate_teachers')->name('update_rate_teachers');
     Route::post('/destroy_rate_teachers',              'Teachers\RateTeacherController@destroy_rate_teachers')->name('destroy_rate_teachers');


     // follwers
     Route::get('/follwers',                       'Teachers\FollwersController@follwers')->name('follwers')->middleware(['permission:المتابعين']);
     Route::get('/get_all_follwers',               'Teachers\FollwersController@get_all_follwers')->name('get_all_follwers');
     Route::post('/store_follwers',                'Teachers\FollwersController@store_follwers')->name('store_follwers');
     Route::post('/update_follwers',               'Teachers\FollwersController@update_follwers')->name('update_follwers');
     Route::post('/destroy_follwers',              'Teachers\FollwersController@destroy_follwers')->name('destroy_follwers');


    // settings_teacher
    Route::get('/settings_teacher',                       'Teachers\SettingTecherController@settings_teacher')->name('settings_teacher')->middleware(['permission:اعدادات الحساب']);
    Route::get('/get_all_settings_teacher',               'Teachers\SettingTecherController@get_all_settings_teacher')->name('get_all_settings_teacher');
    Route::post('/store_settings_teacher',                'Teachers\SettingTecherController@store_settings_teacher')->name('store_settings_teacher');

    Route::post('/destroy_settings_teacher',              'Teachers\SettingTecherController@destroy_settings_teacher')->name('destroy_settings_teacher');
    
    Route::post('/add_section_to_course',                 'Teachers\SectionController@add_section_to_course')->name('add_section_to_course');

     // review_courses
     Route::get('/review_courses',                       'Teachers\ReviewCourseController@review_courses')->name('review_courses');
     Route::get('/get_all_review_courses',               'Teachers\ReviewCourseController@get_all_review_courses')->name('get_all_review_courses');
     Route::post('/store_review_courses',                'Teachers\ReviewCourseController@store_review_courses')->name('store_review_courses');
     Route::post('/update_review_courses',               'Teachers\ReviewCourseController@update_review_courses')->name('update_review_courses');
     Route::post('/destroy_review_courses',              'Teachers\ReviewCourseController@destroy_review_courses')->name('destroy_review_courses');
     Route::get('/get_sections_from_course/{id}',        'Teachers\CourseController@get_sections_from_course')->name('get_sections_from_course');



     // comments
     Route::get('/comments/{id}',                       'Teachers\CommentController@comments')->name('comments')->middleware(['permission:التعليقات']);
     Route::get('/get_all_comments/{id}',               'Teachers\CommentController@get_all_comments')->name('get_all_comments');
     Route::post('/store_comments',                'Teachers\CommentController@store_comments')->name('store_comments');
     Route::post('/update_comments',               'Teachers\CommentController@update_comments')->name('update_comments');
     Route::post('/destroy_comments',              'Teachers\CommentController@destroy_comments')->name('destroy_comments');



     // reply
     Route::get('/reply/{id}',                  'Teachers\ReplyController@reply')->name('reply')->middleware(['permission:الردود']);
     Route::get('/get_all_reply/{id}',          'Teachers\ReplyController@get_all_reply')->name('get_all_reply');
     Route::post('/store_reply',                'Teachers\ReplyController@store_reply')->name('store_reply');
     Route::post('/update_reply',               'Teachers\ReplyController@update_reply')->name('update_reply');
     Route::post('/destroy_reply',              'Teachers\ReplyController@destroy_reply')->name('destroy_reply');

     
     Route::get('/statistics',                       'Teachers\CourseController@statistics')->name('statistics')->middleware(['permission:الاحصائيات']);

     // courses
     Route::get('/courses',                       'Teachers\CourseController@courses')->name('courses')->middleware(['permission:الدورات']);
     Route::get('/get_all_courses',               'Teachers\CourseController@get_all_courses')->name('get_all_courses');
     Route::post('/store_courses',                'Teachers\CourseController@store_courses')->name('store_courses');
     Route::post('/update_courses',               'Teachers\CourseController@update_courses')->name('update_courses');
     Route::post('/destroy_courses',              'Teachers\CourseController@destroy_courses')->name('destroy_courses');
     Route::post('/is_post_route',                'Teachers\CourseController@is_post_route')->name('is_post_route');
     Route::post('/has_ended_route',              'Teachers\CourseController@has_ended_route')->name('has_ended_route');
     Route::post('/is_view_change',               'Teachers\CourseController@is_view_change')->name('is_view_change');
     Route::post('/is_view_subscriper_change',    'Teachers\CourseController@is_view_subscriper_change')->name('is_view_subscriper_change');


     // sections
     Route::get('/sections/{id?}',                 'Teachers\SectionController@sections')->name('sections')->middleware(['permission:الفصول']);
     Route::get('/get_all_sections/{id?}',         'Teachers\SectionController@get_all_sections')->name('get_all_sections');
     Route::post('/store_sections',                'Teachers\SectionController@store_sections')->name('store_sections');
     Route::post('/update_sections',               'Teachers\SectionController@update_sections')->name('update_sections');
     Route::post('/destroy_sections',              'Teachers\SectionController@destroy_sections')->name('destroy_sections');
     Route::get('/get_sections/{id}',              'Teachers\SectionController@get_sections')->name('get_sections');


     // lessons
     Route::get('/lessons/{id?}',                 'Teachers\LessonController@lessons')->name('lessons')->middleware(['permission:الدروس']);
     Route::get('/get_all_lessons/{id?}',         'Teachers\LessonController@get_all_lessons')->name('get_all_lessons');
     Route::get('/get_all_attachments/{id?}',     'Teachers\LessonController@get_all_attachments')->name('get_all_attachments');
     Route::post('/store_lessons',                'Teachers\LessonController@store_lessons')->name('store_lessons');
     Route::post('/change_lesson_order_index',                'Teachers\LessonController@changeOrderIndex')->name('changeOrderIndex');
     
     Route::post('/update_lessons',               'Teachers\LessonController@update_lessons')->name('update_lessons');
     Route::post('/destroy_lessons',              'Teachers\LessonController@destroy_lessons')->name('destroy_lessons');
     Route::post('/destroy_attachmetns',              'Teachers\LessonController@destroy_attachmetns')->name('destroy_attachmetns');
     Route::post('/add_lesson_to_another_section','Teachers\LessonController@add_lesson_to_another_section')->name('add_lesson_to_another_section');
     Route::get('/details/{id}',                  'Teachers\LessonController@details')->name('details');
     Route::post('/add_attachments',              'Teachers\LessonController@add_attachments')->name('add_attachments');
     Route::post('/disabled_comments_route',              'Teachers\LessonController@disabled_comments_route')->name('disabled_comments_route');
     Route::post('/disabled_routs_comments_route',              'Teachers\LessonController@disabled_routs_comments_route')->name('disabled_routs_comments_route');
     Route::post('/cancel_lesson',              'Teachers\LessonController@cancel_lesson')->name('cancel_lesson');
     Route::get('/get_views/{id?}',              'Teachers\LessonController@get_views')->name('get_views');


     Route::post('/change_status',               'Teachers\UserController@change_status')->name('change_status');
     Route::post('/update_status_laravel',               'Teachers\UserController@update_status_laravel')->name('update_status_laravel');


     // subjects
     Route::get('/subjects',                       'Teachers\SubjectController@subjects')->name('subjects');
     Route::get('/get_all_subjects',               'Teachers\SubjectController@get_all_subjects')->name('get_all_subjects');
     Route::post('/store_subjects',                'Teachers\SubjectController@store_subjects')->name('store_subjects');
     Route::post('/update_subjects',               'Teachers\SubjectController@update_subjects')->name('update_subjects');
     Route::post('/destroy_subjects',              'Teachers\SubjectController@destroy_subjects')->name('destroy_subjects');

     Route::get('/get_levels_in_form_add/{id}',        'LevelController@get_levels_in_form_add')->name('get_levels_in_form_add');



     Route::get('/get_all_role',                   'Teachers\PermissionController@get_all_role')->name('get_all_role');
     // Route::resource('roles', 'RoleController')->middleware(['permission:الصلاحيات']);
     Route::resource('roles', 'Teachers\RoleController')->middleware(['permission:الصلاحيات']);
     Route::post('/update_rolee',                   'Teachers\RoleController@update_rolee')->name('update_rolee');



    // admins
    //     Route::get('/admins',                  'AdminController@admins')->name('admins')->middleware(['permission:فريق النظام']);
    Route::get('/admins',                         'Teachers\AdminController@admins')->name('admins')->middleware(['permission:فريق النظام']);
    Route::get('/get_all_admins',                 'Teachers\AdminController@get_all_admins')->name('get_all_admins');
    Route::post('/store_admins',                  'Teachers\AdminController@store_admins')->name('store_admins');
    Route::post('/update_admins',                 'Teachers\AdminController@update_admins')->name('update_admins');
    Route::post('/destroy_admins',                'Teachers\AdminController@destroy_admins')->name('destroy_admins');

    Route::get('/notification_teacher',                   'Teachers\NotificationTeacherController@notification_teacher')->name('notification_teacher');


    Route::post('/upload_bu/{name}/{id}/{name_teacher}',                 'Teachers\LessonController@upload_bunny')->name('upload_bunny')->middleware("auth:teachers");
});

Route::post('teachers/update_settings_teacher',               'Teachers\SettingTecherController@update_settings_teacher')->name('teachers.update_settings_teacher');

Route::get('file-upload',                    'FileUploadController@index')->name('files.index');
Route::post('file-upload/upload-large-files','FileUploadController@uploadLargeFiles')->name('files.upload.large');

// Route::post('/upload_vimeo/{id?}',                 'Teachers\LessonController@upload_vimeo')->name('upload_vimeo')->middleware("auth:teachers");

