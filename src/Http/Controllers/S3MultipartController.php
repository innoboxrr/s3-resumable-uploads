<?php

namespace Innoboxrr\S3ResumableUploads\Http\Controllers;

use Innoboxrr\S3ResumableUploads\Http\Requests\S3Multipart\{
    InitiateUploadRequest,
    SignPartUploadRequest,
    CompleteUploadRequest
};

class S3MultipartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function initiateUpload(InitiateUploadRequest $request)
    {
        return $request->handle();
    }

    public function signPartUpload(SignPartUploadRequest $request)
    {
        return $request->handle();
    }

    public function completeUpload(CompleteUploadRequest $request)
    {
        return $request->handle();
    }

}