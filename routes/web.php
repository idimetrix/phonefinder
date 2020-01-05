<?php
Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/blog/create', 'ArticleController@create');
    Route::post('/blog/create', 'ArticleController@store');
    Route::patch('/blog/edit/{id}', 'ArticleController@update');
    Route::delete('/blog/{id}', 'ArticleController@destroy');
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'AdminController@index');
        Route::get('report', 'AdminController@report');
        Route::get('settings', 'AdminController@showSettings');
        Route::get('settings/edit/{id}', 'AdminController@editSettings');
        Route::patch('settings/{id}', 'AdminController@updateSettings');
        Route::get('delete', 'AdminController@showDelete');
        Route::post('delete/{id}', 'AdminController@deleteNumber');
        Route::delete('report/{id}', 'AdminController@destroyReport');
        Route::get('phone', 'AdminController@create');
        Route::post('phone', 'AdminController@store');
        Route::get('views', 'AdminController@viewsDiagram');
        Route::get('translation', 'AdminController@indexTranslate');
        Route::get('translation/{name}', 'AdminController@showTranslate');
        Route::patch('translation/{name}', 'AdminController@updateTranslate');
        Route::get('blog/edit/{id}', 'ArticleController@edit');
        Route::resource('area', 'AreaController', ['except' => ['show']]);
        Route::get('safe-unsafe', 'IpController@fakeSafeUnsafe');
        Route::resource('ips', 'IpController', ['except' => ['show']]);
    });
});

Route::group(['middleware' => 'black.list'], function () {
    Route::get('/', 'PagesController@home');
    Route::get('/blog', 'ArticleController@index');
    Route::get('/blog/{id}', 'ArticleController@show');
    Route::post('/blog/{id}/comment', 'ArticleController@storeComment');
    Route::get('/phone/{number}', 'PagesController@phone');
    Route::get('/report/{number?}', 'PagesController@report');
    Route::get('/about', 'PagesController@about');
    Route::get('/prefix', 'AreaController@areaCode');
    Route::get('/prefix/{prefix}', 'AreaController@areaCodeNumbers');
    Route::get('/prefix/{prefix}/code/{code}', 'AreaController@suitedNumbers');
    Route::get('/contact_us', 'PagesController@getContacts');
    Route::get('/top-safe', 'PagesController@getSafe');
    Route::get('/top-unsafe', 'PagesController@getUnsafe');
    Route::get('/privacy_policy', 'PagesController@getPrivacy');
    Route::get('/terms_of_use', 'PagesController@getTerms');
    Route::get('phone/detailed/{phone}', 'PagesController@details');
    Route::get('/get_captcha/{config?}', function (\Mews\Captcha\Captcha $captcha, $config = 'default') {
        return $captcha->src($config);
    });
    Route::resource('top-search', 'SearchController');
    Route::post('/phone/{number}/like', 'ActionsController@like');
    Route::post('/phone/{number}/comment', 'ActionsController@comment');
    Route::post('/phone/report', 'ActionsController@report');
    Route::post('/admin_message', 'PagesController@admin_message');
});
