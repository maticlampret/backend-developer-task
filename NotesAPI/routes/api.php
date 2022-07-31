<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoldersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//In the future I could create Api folder inside controllers and move my 2 controllers in there to make file organisations better
//wrote custom middleware that will attempt to auth user, but will still go to the end point if the auth fails
Route::group(['middleware' => ['user.auth']], function() {
    Route::get('/Note','App\Http\Controllers\NotesController@getNotes');
    Route::get('/Note/{idNote}', 'App\Http\Controllers\NotesController@GetNote');

});

/* I wrote coustom middleware that works similiar to auth.basic but uses username to auth user
I also wrote this as a new middleware in case we would need to add mores stuff like custom exceptions and so on later on.

If needed I also know how write my own middleware that decodes the authorization data send in header and "manually" get the user
from database if that data is correct and return exception otherwise. Currently I am using tools that are available to me, through
laravel but also know how to write it manually. */
Route::group(['middleware' => ['auth.username']], function() {
    //Folders
    Route::get('/Folder','App\Http\Controllers\FoldersController@GetFolders');
    Route::get('/Folder/{idFolder}','App\Http\Controllers\FoldersController@GetFolder');
    Route::post('/Folder', 'App\Http\Controllers\FoldersController@CreateFolder');
    Route::put('/Folder/{idFolder}', 'App\Http\Controllers\FoldersController@UpdateFolder');
    Route::delete('/Folder/{idFolder}', 'App\Http\Controllers\FoldersController@DeleteFolder');

    //Notes
    Route::put('/Note/{idNote}', 'App\Http\Controllers\NotesController@UpdateNote');
    Route::post('/Note', 'App\Http\Controllers\NotesController@CreateNote');
    Route::delete('/Note/{idNote}', 'App\Http\Controllers\NotesController@DeleteNote');

    //Note bodies
    Route::post('/NoteBody', 'App\Http\Controllers\NotesController@CreateNodeBody');
    Route::put('/NoteBody', 'App\Http\Controllers\NotesController@UpdateNoteBody');
    Route::delete('/NoteBody', 'App\Http\Controllers\NotesController@DeleteNoteBody');
});
