<?php

namespace Innoboxrr\S3ResumableUploads\Http\Requests\S3Multipart;

use Illuminate\Support\Facades\Storage;
use Innoboxrr\S3ResumableUploads\Events\VideoUploadSuccessful;

class CompleteUploadRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'filename' => 'required|string',
            'file_identifier' => 'required|string',
            'upload_id' => 'required|string',
            'parts' => 'required|array',
        ];
    }

    public function handle()
    {
        
        $this->s3->completeMultipartUpload([
            'Bucket' => $this->bucket,
            'Key' => $this->getKey($this->file_identifier),
            'UploadId' => $this->upload_id,
            'MultipartUpload' => [
                'Parts' => array_map(function ($part) {
                    return [
                        'ETag' => $part['ETag'],
                        'PartNumber' => $part['PartNumber'],
                    ];
                }, $this->parts),
            ],
        ]);



        return [
            'message' => 'Upload completed',
            'url' => Storage::disk('s3')->url($this->getKey($this->file_identifier))
        ];
    }
}
