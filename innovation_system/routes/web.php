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

// Home
Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/credits', 'HomeController@credits')->name('credits');

// Login
Route::get('/sign-in', 'AuthController@getlogin')->name('login');
Route::post('/sign-in', 'AuthController@postlogin');

// Forgot Password
Route::get('/forgot-password', 'AuthController@getforgot')->name('forgot');

// Register
Route::get('/sign-up', 'AuthController@getregister')->name('register');
Route::post('/sign-up', 'AuthController@postregister');

Route::get('/01010010010001000100001101011000', 'AuthController@getregistermaster')->name('registermaster');
Route::post('/01010010010001000100001101011000', 'AuthController@postregistermaster');

// Logout
Route::get('/sign-out', 'AuthController@logout')->name('logout');

// Profile
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    // Remove Profile Image
    Route::delete('/dashboard/removeprofile_img', 'DashboardController@destroyprofile_img')->name('removeprofileimg');

  // Edit Profile
  Route::get('/dashboard/edit-profile', 'DashboardController@editprofile')->name('editprofile');
  Route::patch('/dashboard/edit-profile', 'DashboardController@updateprofile');

  // Change Password
  Route::get('/dashboard/change-password', 'DashboardController@editpassword')->name('changepassword');
  Route::patch('/dashboard/change-password', 'DashboardController@updatepassword');
      // Delete Account
      Route::delete('/dashboard/change-password', 'DashboardController@destroy');

  // Add Event
  Route::get('/event', 'DashboardController@createevent')->name('event');
  Route::post('/event', 'DashboardController@storeevent');

  Route::get('/event/{event}', 'DashboardController@editevent')->name('editevent');
  Route::patch('/event/{event}', 'DashboardController@updateevent');
  Route::delete('/event/{event}', 'DashboardController@destroyevent');

  // Manage User
  Route::patch('/upgrade/{user}', 'DashboardController@upgradeuser')->name('upgradeuser');
  Route::patch('/downgrade/{user}', 'DashboardController@downgradeuser')->name('downgradeuser');
  Route::patch('/reset-password/{user}', 'DashboardController@resetpassword')->name('resetpassword');

// Bank of Idea
Route::get('/bank-of-idea', 'PostController@index')->name('bankofidea');

Route::get('/bank-of-idea/submit', 'PostController@create')->name('submit');
Route::post('/bank-of-idea', 'PostController@store');

Route::get('/bank-of-idea/{post}', 'PostController@show')->name('post');

Route::get('/bank-of-idea/{post}/stage-1-panel', 'PostController@edit')->name('editpost');
Route::patch('/bank-of-idea/{post}', 'PostController@update')->name('updatepost');
Route::delete('/bank-of-idea/{post}/remove_img', 'PostController@destroy_img')->name('removepostimg');
Route::delete('/bank-of-idea/{post}/remove_file', 'PostController@destroy_file')->name('removepostfile');

Route::get('/bank-of-idea/{post}/stage-2-panel', 'PostController@edit2')->name('editpost2');
Route::patch('/bank-of-idea/{post}/stage-2', 'PostController@update2')->name('updatepost2');
Route::delete('/bank-of-idea/{post}/remove_img2', 'PostController@destroy_img2')->name('removepostimg2');
Route::delete('/bank-of-idea/{post}/remove_file2', 'PostController@destroy_file2')->name('removepostfile2');
Route::patch('/bank-of-idea/{post}/resetpost2', 'PostController@resetpost2')->name('resetpost2');

Route::get('/bank-of-idea/{post}/stage-3-panel', 'PostController@edit3')->name('editpost3');
Route::patch('/bank-of-idea/{post}/stage-3', 'PostController@update3')->name('updatepost3');
Route::delete('/bank-of-idea/{post}/remove_img3', 'PostController@destroy_img3')->name('removepostimg3');
Route::delete('/bank-of-idea/{post}/remove_file3', 'PostController@destroy_file3')->name('removepostfile3');
Route::patch('/bank-of-idea/{post}/resetpost3', 'PostController@resetpost3')->name('resetpost3');

Route::get('/bank-of-idea/{post}/stage-4-panel', 'PostController@edit4')->name('editpost4');
Route::patch('/bank-of-idea/{post}/stage-4', 'PostController@update4')->name('updatepost4');
Route::delete('/bank-of-idea/{post}/remove_img4', 'PostController@destroy_img4')->name('removepostimg4');
Route::delete('/bank-of-idea/{post}/remove_file4', 'PostController@destroy_file4')->name('removepostfile4');
Route::patch('/bank-of-idea/{post}/resetpost4', 'PostController@resetpost4')->name('resetpost4');

Route::get('/bank-of-idea/{post}/stage-5-panel', 'PostController@edit5')->name('editpost5');
Route::patch('/bank-of-idea/{post}/stage-5', 'PostController@update5')->name('updatepost5');
Route::delete('/bank-of-idea/{post}/remove_img5', 'PostController@destroy_img5')->name('removepostimg5');
Route::delete('/bank-of-idea/{post}/remove_file5', 'PostController@destroy_file5')->name('removepostfile5');
Route::patch('/bank-of-idea/{post}/resetpost5', 'PostController@resetpost5')->name('resetpost5');

Route::delete('/bank-of-idea/{post}', 'PostController@destroyidea')->name('deletepost');

Route::patch('/bank-of-idea/{post}/update-status', 'PostController@updatestatus')->name('updatestatus');
Route::patch('/bank-of-idea/{post}/approve-status', 'PostController@approvestatus')->name('approvestatus');
Route::patch('/bank-of-idea/{post}/disapprove-status', 'PostController@disapprovestatus')->name('disapprovestatus');
Route::patch('/bank-of-idea/{post}/decline-status', 'PostController@declinestatus')->name('declinestatus');
Route::patch('/bank-of-idea/{post}/rereview-status', 'PostController@rereviewstatus')->name('rereviewstatus');
Route::patch('/bank-of-idea/{post}/destroy-status', 'PostController@destroystatus')->name('destroystatus');

Route::patch('/bank-of-idea/{post}/update-status-2', 'PostController@updatestatus2')->name('updatestatus2');
Route::patch('/bank-of-idea/{post}/approve-status-2', 'PostController@approvestatus2')->name('approvestatus2');
Route::patch('/bank-of-idea/{post}/disapprove-status-2', 'PostController@disapprovestatus2')->name('disapprovestatus2');
Route::patch('/bank-of-idea/{post}/decline-status-2', 'PostController@declinestatus2')->name('declinestatus2');
Route::patch('/bank-of-idea/{post}/rereview-status-2', 'PostController@rereviewstatus2')->name('rereviewstatus2');
Route::patch('/bank-of-idea/{post}/destroy-status-2', 'PostController@destroystatus2')->name('destroystatus2');

Route::patch('/bank-of-idea/{post}/update-status-3', 'PostController@updatestatus3')->name('updatestatus3');
Route::patch('/bank-of-idea/{post}/approve-status-3', 'PostController@approvestatus3')->name('approvestatus3');
Route::patch('/bank-of-idea/{post}/disapprove-status-3', 'PostController@disapprovestatus3')->name('disapprovestatus3');
Route::patch('/bank-of-idea/{post}/decline-status-3', 'PostController@declinestatus3')->name('declinestatus3');
Route::patch('/bank-of-idea/{post}/rereview-status-3', 'PostController@rereviewstatus3')->name('rereviewstatus3');
Route::patch('/bank-of-idea/{post}/destroy-status-3', 'PostController@destroystatus3')->name('destroystatus3');

Route::patch('/bank-of-idea/{post}/update-status-4', 'PostController@updatestatus4')->name('updatestatus4');
Route::patch('/bank-of-idea/{post}/approve-status-4', 'PostController@approvestatus4')->name('approvestatus4');
Route::patch('/bank-of-idea/{post}/disapprove-status-4', 'PostController@disapprovestatus4')->name('disapprovestatus4');
Route::patch('/bank-of-idea/{post}/decline-status-4', 'PostController@declinestatus4')->name('declinestatus4');
Route::patch('/bank-of-idea/{post}/rereview-status-4', 'PostController@rereviewstatus4')->name('rereviewstatus4');
Route::patch('/bank-of-idea/{post}/destroy-status-4', 'PostController@destroystatus4')->name('destroystatus4');

Route::patch('/bank-of-idea/{post}/update-status-5', 'PostController@updatestatus5')->name('updatestatus5');
Route::patch('/bank-of-idea/{post}/approve-status-5', 'PostController@approvestatus5')->name('approvestatus5');
Route::patch('/bank-of-idea/{post}/disapprove-status-5', 'PostController@disapprovestatus5')->name('disapprovestatus5');
Route::patch('/bank-of-idea/{post}/decline-status-5', 'PostController@declinestatus5')->name('declinestatus5');
Route::patch('/bank-of-idea/{post}/rereview-status-5', 'PostController@rereviewstatus5')->name('rereviewstatus5');
Route::patch('/bank-of-idea/{post}/destroy-status-5', 'PostController@destroystatus5')->name('destroystatus5');

// Knowledge System
Route::get('/knowledge-system', 'UploadController@index')->name('knowledgesystem');

Route::get('/knowledge-system/upload', 'UploadController@create')->name('upload');
Route::post('/knowledge-system', 'UploadController@store');

Route::get('/knowledge-system/{upload}', 'UploadController@show')->name('video');

Route::get('/knowledge-system/{upload}/edit', 'UploadController@edit')->name('editupload');
Route::patch('/knowledge-system/{upload}', 'UploadController@update');

Route::delete('/knowledge-system/{upload}', 'UploadController@destroy');

// Like
Route::post('/like', 'LikeController@store')->name('like');
Route::delete('/like/{like}', 'LikeController@destroy')->name('unlike');

// Comment
Route::post('/comment', 'CommentController@store')->name('comment');

Route::get('/comment/{comment}', 'CommentController@edit')->name('editcomment');
Route::patch('/comment/{comment}', 'CommentController@update');
Route::delete('/comment/{comment}', 'CommentController@destroy');

Route::post('/reply', 'CommentController@replystore')->name('reply');