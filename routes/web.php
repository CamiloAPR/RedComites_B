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

Route::get('/', function () {
    return view('welcome');
});

Route::get('foo2', function () {
    return 'Hello';
});

Route::resource('committee','CommitteeController');
Route::resource('user','UserController');
Route::resource('committee_member','CommitteeMemberController');
Route::resource('committee_status','CommitteeStatusController');
Route::resource('member','MemberController');
Route::resource('publication','PublicationController');
Route::resource('publication_history','PublicationHistoryController');
Route::resource('publication_status','PublicationStatusController');
Route::resource('role','RoleController');
Route::get('user/user_log/{id}','UserController@indexUser');
Route::get('publication/committe_id/{id}','Publication@indexCommittee');
Route::get('committee/committee_id/{id}','CommitteeController@indexCommittee');
Route::get('publication/publication_id/{id}','PublicationController@indexPublication');
Route::get('publication/committee_id/{id}','PublicationController@indexCommittee');


