<?php



// Route::get('notify', function () {




//     //$user = \App\User::find(3);
//     //$user->notify(new \App\Notifications\NewNotification());
// });

	Route::get('/notify', 'DocumentController@notify');//show


///////////public routes
Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');
/*Route::get('/', function () {
    return view('welcome');
});
*/
//downloads 
Route::post('create-zip', 'DocumentController@zip')->name('create-zip');
Route::post('create_zip_filter', 'DocumentController@zip_filter');


//
Auth::routes();


///just admin
Route::middleware(['auth','admin','web'])->group(function () {
	Route::get('/system/companie', 'CompanieController@index');//show
	Route::post('/system/companie', 'CompanieController@store');//create
	Route::post('/system/companie/delete', 'CompanieController@destroy');//delete



	Route::post('/system/companie/edit/{id}', 'CompanieController@update');//update
	Route::get('/system/companie/{companie}/documents', 'DocumentController@show')->name('system');
	Route::get('/system/user.html', 'UserController@index');//show
	Route::post('/system/user.html', 'UserController@store');//show
	Route::post('/system/edit/user.html', 'UserController@update');//update

	//////////////////////////////////

	Route::post('/system/companie/documents/validate', 'DocumentController@document_validate');
	//////////////////////////////


	//role,type,access
	Route::get('/type', 'typeController@index');//update


	///////////////////////////////////roles
	Route::get('/role', 'RoleController@index');//show
	Route::get('/api/roles', 'RoleController@getRoles');
	Route::post('/role/edit', 'RoleController@update');
	Route::post('/role/new', 'RoleController@store');
	Route::post('/role/delete', 'RoleController@destroy');
	Route::get('/role/role_access/{id}', 'RoleController@access_view');//show

	//////////////////////////////



	/////////////////////////////////menus
		Route::get('/menu', 'MenuController@index');
		Route::get('/menu/show', 'MenuController@get');
		Route::post('/menu/update', 'MenuController@update');
		Route::post('/menu/new', 'MenuController@store');
		Route::post('/menu/delete', 'MenuController@destroy');
		Route::get('/menu/get', 'MenuController@getMenu');
	////////////////////////////////

	/////////////////////////////////access
		Route::get('/access', 'AccessController@index');
		Route::get('/access/show', 'AccessController@get');
		Route::post('/access/update', 'AccessController@update');
		Route::post('/access/new', 'AccessController@store');
		Route::post('/access/delete', 'AccessController@destroy');
		Route::post('/access/update_to_role', 'AccessController@update_to_role');
	////////////////////////////////

    ///////////////////////documents
		Route::post('/document/delete','DocumentController@destroyed');

});





///just companies
Route::middleware(['auth','companie'])->group(function () {

	//Route::get('/companie/{companie}/document', 'DocumentController@show');
	Route::get('/companie/document/load', 'DocumentController@index');
	//Route::get('/companie/document/load', 'DocumentController@index');
	Route::post('/companie/document', 'DocumentController@store');
	Route::delete('/document/delete/{id}','DocumentController@destroy');

	

	//Route::get('/try','DocumentController@try');



	Route::get('/document/{companie}', 'DocumentController@show');


});




/////////////////////////////APIS
Route::get('/api/user', 'UserController@getUsers');
Route::get('/send', 'DocumentController@sendemail');