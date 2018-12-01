<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

	Route::get('dashboard', 'AdminDashboardController@dashboard')->name('admin.dashboard');
	Route::get('/', 'AdminDashboardController@redirect')->name('backpack');

	CRUD::resource('year', 'YearCrudController');
	CRUD::resource('academicyear', 'AcademicYearCrudController');
	CRUD::resource('subject', 'SubjectCrudController');
	Route::post('teacher/resetpassword/{id}', 'TeacherCrudController@teacherResetPassword')->name('teacher.reset.password');
	CRUD::resource('teacher', 'TeacherCrudController');
	/*Route::get('student/uploadcsv', 'StudentCrudController@uploadCsv')->name('student.csv');
	Route::post('student/uploadcsv', 'StudentCrudController@submitCsv')->name('student.upload.csv');*/
	Route::post('student/resetpassword/{id}', 'StudentCrudController@studentResetPassword')->name('student.reset.password');
	CRUD::resource('student', 'StudentCrudController');

	Route::get('download-students', 'StudentCrudController@downloadStudents');

	Route::get('section/{id}/addteachers', 'SectionCrudController@addTeachers')->name('section.teachers');
	/*Route::match(['PUT', 'PATCH'], 'section/{id}/addteachers', 'SectionCrudController@addTeacherOnSubject')->name('section.teachers.update');*/
	Route::post('section/{id}/addteacherss', 'SectionCrudController@addTeacherOnSubject')->name('section.teachers.update');
	Route::get('section/{id}/students', 'SectionCrudController@viewStudents')->name('section.students.view');
	Route::get('academicyear/{id}/sections', 'AdminDashboardController@viewAcademicYearSection')->name('academic.section');

	CRUD::resource('section', 'SectionCrudController');
	CRUD::resource('facility', 'FacilityCrudController');
	CRUD::resource('administration', 'AdministrationCrudController');
	CRUD::resource('page_content', 'Page_contentCrudController');
	CRUD::resource('announcement', 'AnnouncementCrudController');

	// carousel routes
	Route::get('carousels', 'CarouselController@index')->name('carousel.index');
	Route::get('carousels/create', 'CarouselController@create')->name('carousel.create');
	Route::post('carousels/create', 'CarouselController@store')->name('carousel.store');
	Route::get('carousels/{id}/edit', 'CarouselController@edit')->name('carousel.edit');
	Route::match(['PUT', 'PATCH'], 'carousels/{id}/edit', 'CarouselController@update')->name('carousel.update');
	Route::delete('carousels/{id}/delete', 'CarouselController@destroy')->name('carousel.destroy');

	// logo routes
	Route::get('logos', 'LogoController@index')->name('logo.index');
	Route::get('logos/create', 'LogoController@create')->name('logo.create');
	Route::post('logos/create', 'LogoController@store')->name('logo.store');
	Route::get('logos/{id}/edit', 'LogoController@edit')->name('logo.edit');
	Route::match(['PUT', 'PATCH'], 'logos/{id}/edit', 'LogoController@update')->name('logo.update');
	Route::delete('logos/{id}/delete', 'LogoController@destroy')->name('logo.destroy');

	// schoolname routes
	Route::get('schoolnames', 'SchoolnameController@index')->name('schoolname.index');
	Route::get('schoolnames/create', 'SchoolnameController@create')->name('schoolname.create');
	Route::post('schoolnames/create', 'SchoolnameController@store')->name('schoolname.store');
	Route::get('schoolnames/{id}/edit', 'SchoolnameController@edit')->name('schoolname.edit');
	Route::match(['PUT', 'PATCH'], 'schoolnames/{id}/edit', 'SchoolnameController@update')->name('schoolname.update');
	Route::delete('schoolnames/{id}/delete', 'SchoolnameController@destroy')->name('schoolname.destroy');

	// about routes
	Route::get('abouts', 'AboutController@index')->name('about.index');
	Route::get('abouts/create', 'AboutController@create')->name('about.create');
	Route::post('abouts/create', 'AboutController@store')->name('about.store');
	Route::get('abouts/{id}/edit', 'AboutController@edit')->name('about.edit');
	Route::match(['PUT', 'PATCH'], 'abouts/{id}/edit', 'AboutController@update')->name('about.update');
	Route::delete('abouts/{id}/delete', 'AboutController@destroy')->name('about.destroy');

	// inbox routes
	Route::get('messages', 'MessageController@index')->name('message.index');
	Route::get('messages/show', 'MessageController@show')->name('message.show');
	Route::delete('messages/{id}/delete', 'MessageController@destroy')->name('message.destroy');

	// user routes
	Route::get('users', 'UserController@index')->name('user.index');
	Route::get('users/create', 'UserController@create')->name('user.create');
	Route::post('users/create', 'UserController@store')->name('user.store');
	Route::get('users/{id}/edit', 'UserController@edit')->name('user.edit');
	Route::match(['PUT', 'PATCH'], 'users/{id}/edit', 'UserController@update')->name('user.update');
	Route::delete('users/{id}/delete', 'UserController@destroy')->name('user.destroy');

	// user routes
	Route::get('logs', 'LogController@index')->name('log.index');
	Route::delete('logs/{id}/delete', 'LogController@destroy')->name('log.destroy');

	// album routes
	Route::get('albums', 'AlbumController@index')->name('album.index');
	Route::get('albums/create', 'AlbumController@create')->name('album.create');
	Route::post('albums/create', 'AlbumController@store')->name('album.store');
	Route::get('albums/{id}', 'AlbumController@show')->name('album.show');
	Route::get('albums/{id}/edit', 'AlbumController@edit')->name('album.edit');
	Route::match(['PUT', 'PATCH'], 'albums/{id}/edit', 'AlbumController@update')->name('album.update');
	Route::delete('albums/{id}/delete', 'AlbumController@destroy')->name('album.destroy');

	// maintenance route
	// Route::get('oops', 'MaintenaceController@oops')->name('oops');

}); // this should be the absolute last line of this file
