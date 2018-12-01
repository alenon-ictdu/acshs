<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function() {
	return redirect()->route('student.login');
});

Route::get('/facilities','PageController@facilityPage')->name('facilities');
Route::get('/albums','PageController@albumPage')->name('albums');
Route::get('/albums/{id}/images','PageController@albumImagesPage')->name('album.images');
Route::get('/announcements','PageController@announcementPage')->name('announcements');
Route::get('/administrations','PageController@administrationPage')->name('administrations');
Route::get('/','HomeController@landingpage')->name('landing');


// Admin Login
Route::get('/admin/logout', 'Auth\AdminLoginController@adminLogout')->name('admin.logout');
Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('/admin', 'Auth\AdminLoginController@redirect')->name('redirect-admin-login');


//Auth::routes();
// Authentication Routes...
	// $this->get('/login', 'Auth\LoginController@showLoginForm')->name('login');
	// $this->post('/login', 'Auth\LoginController@login');
	// $this->post('/logout', 'Auth\LoginController@logout')->name('logout');

	// // Registration Routes...
	// $this->get('/naNljDFJvX', 'Auth\RegisterController@showRegistrationForm')->name('register');
	// $this->post('/naNljDFJvX', 'Auth\RegisterController@register');

	// Password Reset Routes...
	$this->get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	 $this->post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	$this->get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	$this->post('/password/reset', 'Auth\ResetPasswordController@reset');

// Route::get('/home', 'HomeController@index')->name('home');
Route::post('message/create', 'MessageController@store')->name('message.store');
// student routes
Route::get('/student/login', 'Auth\StudentLoginController@showLoginForm')->name('student.login');
Route::post('/student/login', 'Auth\StudentLoginController@login')->name('student.login.submit');
// Route::get('/student/dashboard', 'StudentController@dashboard')->name('student.dashboard');
Route::get('/student/logout', 'Auth\StudentLoginController@studentLogout')->name('student.logout');
Route::get('/student/account', 'StudentController@viewAccountSettings')->name('student.view.account');
Route::post('/student/updatepicture', 'StudentController@updatePicture')->name('student.update.picture');
Route::post('/student/updateinfo', 'StudentController@updateInfo')->name('student.update.info');
Route::match(['PUT', 'PATCH'], 'student/updatepassword/{id}', 'StudentController@updatePassword')->name('student.update.password');

Route::get('/studentsections', 'Student\GradeController@studentSections')->name('student.sections');
Route::get('/studentsections/{id}/grades', 'Student\GradeController@studentGrades')->name('student.grades');






// teacher routes
Route::get('/sections/{section_id}/subject/{subject_id}/exportstudents', 'Teacher\SectionController@exportCsv')->name('exportcsv');
Route::get('/teacher/login', 'Auth\TeacherLoginController@showLoginForm')->name('teacher.login');
Route::post('/teacher/login', 'Auth\TeacherLoginController@login')->name('teacher.login.submit');
Route::get('/teacher/dashboard', 'TeacherController@dashboard')->name('teacher.dashboard');
Route::get('/teacher/logout', 'Auth\TeacherLoginController@teacherLogout')->name('teacher.logout');
Route::get('/teacher/account', 'TeacherController@viewAccountSettings')->name('teacher.view.account');
Route::post('/teacher/updatepicture', 'TeacherController@updatePicture')->name('teacher.update.picture');
Route::post('/teacher/updateinfo', 'TeacherController@updateInfo')->name('teacher.update.info');
Route::get('/sections/{section_id}/subject/{subject_id}/importstudents', 'Teacher\SectionController@importCsv')->name('teacher.import.csv');
Route::post('/sections/{section_id}/subject/{subject_id}/importstudents', 'Teacher\SectionController@submitCsv')->name('teacher.submit.csv');

//Route::post('student/uploadcsv', 'StudentCrudController@submitCsv')->name('student.upload.csv');
Route::match(['PUT', 'PATCH'], 'teacher/updatepassword/{id}', 'TeacherController@updatePassword')->name('teacher.update.password');



Route::get('/sections', 'Teacher\SectionController@viewSection')->name('teacher.view.section');
Route::get('/sections/{section_id}/subject/{subject_id}/students', 'Teacher\SectionController@viewSectionStudents')->name('teacher.view.section.students');
//Route::post('/teacher/section/student/{id}/grade', 'Teacher\SectionController@')
//Route::match(['PUT', 'PATCH'], '/teacher/section/student/{id}/grade', 'Teacher\SectionController@updateGrade')->name('student.grade.update');
Route::post('/sections/{section_id}/subject/{subject_id}/students', 'Teacher\SectionController@updateGrade')->name('student.grade.update');
