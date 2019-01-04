<?php



// Route::get('notify', function () {




//     //$user = \App\User::find(3);
//     //$user->notify(new \App\Notifications\NewNotification());
// });

	Route::get('/notify', 'DocumentController@notify');//show


///////////public routes
Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');


//downloads 
Route::post('create-zip', 'DocumentController@zip')->name('create-zip');
Route::post('create_zip_filter', 'DocumentController@zip_filter');


//
Auth::routes();


///just admin
Route::middleware(['auth','admin'])->group(function () {
	Route::get('/system/companie', 'CompanieController@index');//show
	Route::post('/system/companie', 'CompanieController@store');//create
	Route::post('/system/companie/edit/{id}', 'CompanieController@update');//update





	Route::get('/system/companie/{companie}/documents', 'DocumentController@show')->name('system');
	Route::get('/system/user.html', 'UserController@index');//show
	Route::post('/system/user.html', 'UserController@store');//show
	Route::post('/system/edit/user.html', 'UserController@update');//update
});





///just companies
Route::middleware(['auth','companie'])->group(function () {

	Route::get('/companie/{companie}/document', 'DocumentController@show');
	Route::get('/companie/{companie}/document/load', 'DocumentController@index');
	//Route::get('/companie/document/load', 'DocumentController@index');
	Route::post('/companie/document', 'DocumentController@store');
	Route::delete('/document/delete/{id}','DocumentController@destroy');

});




/////////////////////////////APIS
Route::get('/api/user', 'UserController@getUsers');
Route::get('/send', 'DocumentController@sendemail');