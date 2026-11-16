<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
	//return 'sample';
}); 

Route::get('/en', function() {
	return view('home');
});

//Route::post('/searchresult', 'SearchResultController@show');

Route::get('/search', 'SearchController@show')->name('search');
//Route::get('/searchresult', 'SearchResultController@show');

//Route::get('/testController', 'testController@show')->name('search');


Route::get('/summary/{speciesname}', 'speciessummaryController@show')->name('speciesSummary');

Route::get('/about', 'AboutController@show');
/*
Route::get('/about', function () {
    return view('about');
});
*/
