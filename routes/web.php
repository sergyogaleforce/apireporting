<?php



/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', ['as' => 'dashboard', 'uses' =>function () {
        return view('dashboard');
    }]);

    Route::get('/users', ['as' => 'users', 'uses' =>function () {
        return view('users.index');
    }]);

    Route::get('/users/edit/{user}', ['as' => 'users.edit', 'uses' => 'UsersController@edit']);
    Route::post('/users/update/{user}', ['as' => 'users.update', 'uses' => 'UsersController@update']);
    Route::post('/users/destroy/{user}', ['as' => 'users.destroy', 'uses' => 'UsersController@destroy']);

    Route::get('/docs', ['as' => 'docs', 'uses' =>function () {
        return view('docs');
    }]);


    Route::get('/idexcel', ['as' => 'idexcel', 'uses' =>'IdExcelClientsController@show_id_excel_clients']);
    Route::post('/idexcel/save', ['as' => 'save_id_excel_c', 'uses' => 'IdExcelClientsController@save_id_excel_clients']);

    Route::get('/users/list', ['as' => 'users.list', 'uses' => 'UsersController@index']);
    Route::post('/users/create', ['as' => 'users.create', 'uses' => 'UsersController@create']);
    Route::get('/users/token/{user}', ['as' => 'users.reset.token', 'uses' => 'UsersController@reset_token']);

    Route::get('/home', 'HomeController@index');
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    Route::post('/logout', ['as' => 'auth_post_logout', 'uses' => 'Auth\LoginController@logout']);
});



Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', ['as' => 'auth_get_login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('/login', ['as' => 'auth_post_login', 'uses' => 'Auth\LoginController@login']);
});

Route::get('/', function(){
    if(\Auth::check()){
        return redirect()->route('dashboard');
    }else{
        return response('Page Not Found', 404);
    }
});



use Illuminate\Http\Request;