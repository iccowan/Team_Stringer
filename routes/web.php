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

//Public Pages
Route::get('/', 'HomeController@index');
Route::post('/', 'HomeController@submitSupportTicket');
Route::get('/contact', 'HomeController@support');
Route::post('/contact', 'HomeController@submitSupportTicket');
Route::get('/terms-of-service', 'HomeController@termsOfService');

//Authentication
Route::get('/login', 'AuthController@login')->middleware('guest');
Route::post('/login', 'AuthController@loginUser')->middleware('guest');
Route::get('/register/{plan?}', 'AuthController@register')->middleware('guest');
Route::post('/register/{plan?}', 'AuthController@registerUser')->middleware('guest');
Route::get('/logout', 'AuthController@logoutUser')->middleware('auth');
Route::get('/password-reset', 'AuthController@showPasswordReset')->middleware('guest');
Route::post('/password-reset', 'AuthController@requestPasswordReset')->middleware('guest');
Route::get('/reset-password/{token}', 'AuthController@resetPasswordEmailGet')->middleware('guest');
Route::post('/reset-password/{token}', 'AuthController@resetPasswordEmailVerify')->middleware('guest');
Route::get('/email-verified/reset-password/{token}/{id}', 'AuthController@resetPassword')->middleware('guest');
Route::post('/email-verified/reset-password/{token}/{id}', 'AuthController@saveNewPassword')->middleware('guest');
Route::get('/profile', 'AuthController@updateProfile')->middleware('auth');
Route::post('/profile/save/{id}', 'AuthController@saveProfile')->middleware('auth');
Route::post('/profile/update-plan/{id}', 'AuthController@updatePlan')->middleware('auth', 'role:COACH');

//PayPal Processes
Route::get('/register-completion/complete', 'AuthController@verifyPayPalTransaction');
Route::get('/register-completion/cancel', 'AuthController@cancelPayPal');
Route::get('/upgrade/complete', 'AuthController@upgradeComplete');
Route::get('/upgrade/cancel', 'AuthController@upgradeCancel');

//Coach Pages
Route::get('/coach/roster-manage', 'RosterController@showTeamRoster')->middleware('role:COACH');
Route::get('/coach/roster-manage/new', 'RosterController@newPlayer')->middleware('role:COACH');
Route::post('/coach/roster-manage/new', 'RosterController@saveNewPlayer')->middleware('role:COACH');
Route::post('/coach/roster-manage/save-player/{id}', 'RosterController@updatePlayer')->middleware('role:COACH');
Route::get('/coach/racquets-view', 'StringingController@coachIndex')->middleware('role:COACH');
Route::get('/coach/racquets/complete/{id}', 'StringingController@completeRacquetRequest')->middleware('role:COACH');
Route::get('/coach/racquets/delete/{id}', 'StringingController@deleteRacquetRequest')->middleware('role:COACH');

//Player/Stringer Pages
Route::get('/player/my-racquets', 'StringingController@myRacquets')->middleware('role:ALL_PLAYERS');
Route::get('/player/my-racquets/new', 'StringingController@newRacquet')->middleware('role:ALL_PLAYERS');
Route::post('/player/my-racquets/new', 'StringingController@saveNewRacquet')->middleware('role:ALL_PLAYERS');
Route::get('/player/my-racquets/edit/{id}', 'StringingController@editRacquet')->middleware('role:ALL_PLAYERS');
Route::post('/player/my-racquets/edit/{id}', 'StringingController@saveRacquet')->middleware('role:ALL_PLAYERS');
Route::get('/player/my-racquets/delete/{id}', 'StringingController@deleteRacquet')->middleware('role:ALL_PLAYERS');
Route::get('/player/my-string-requests', 'StringingController@viewStringRequests')->middleware('role:ALL_PLAYERS');
Route::get('/player/my-string-requests/delete/{id}', 'StringingController@deleteStringRequest')->middleware('role:ALL_PLAYERS');
Route::post('/player/my-string-requests', 'StringingController@saveNewStringRequest')->middleware('role:ALL_PLAYERS');

//Stringer Pages
Route::get('/stringer/team-string-requests', 'StringingController@viewTeamRequests')->middleware('role:STRING');
Route::post('/stringer/team-string-requests/search', 'StringingController@searchTeamRequests')->middleware('role:STRING');
Route::get('/stringer/team-string-requests/view-details/{id}', 'StringingController@viewTeamRequestDetails')->middleware('role:STRING');
Route::get('/stringer/team-string-requests/complete/{id}', 'StringingController@completeRequest')->middleware('role:STRING');
Route::post('/profile/stringer-stats-set', 'AuthController@showStringingStats')->middleware('role:STRING');

//Staff Pages
Route::get('/staff/coaches-account-manage', 'StaffController@showCoachAccounts')->middleware('role:STAFF');
Route::get('/staff/coach/view-team/{id}', 'StaffController@showTeamDetails')->middleware('role:STAFF');
Route::post('staff/coach/view-team/{id}', 'StaffController@manageCoach')->middleware('role:STAFF');
Route::get('/staff/staff-manage', 'StaffController@manageStaff')->middleware('id:3');
Route::get('/staff/staff-manage/new', 'StaffController@newStaff')->middleware('id:3');
Route::post('/staff/staff-manage/new', 'StaffController@saveNewStaff')->middleware('id:3');
Route::post('/staff/staff-manage/manage/{id}', 'StaffController@manageStaffMember')->middleware('id:3');
