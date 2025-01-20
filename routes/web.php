<?php

use Illuminate\Support\Facades\Route;

// Upload
Route::post('initiate-upload', 'S3MultipartController@initiateUpload')
	->name('initiate.upload');

Route::post('sign-part-upload', 'S3MultipartController@signPartUpload')
	->name('sign.part.upload');

Route::post('complete-upload', 'S3MultipartController@completeUpload')
	->name('complete.upload');
