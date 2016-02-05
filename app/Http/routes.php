<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']],
    function()
    {
        Route::get('/', 'FileController@login');
        Route::get('user', 'FileController@user');
        Route::post('upload', 'FileController@upload');
        Route::delete('delete', 'FileController@delete');
        Route::get('download/{file}', 'FileController@download');
    }
);