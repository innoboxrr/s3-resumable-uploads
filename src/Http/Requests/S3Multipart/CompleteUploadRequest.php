<?php

namespace Innoboxrr\S3ResumableUploads\Http\Requests\S3Multipart;

use Illuminate\Support\Facades\Storage;
use Innoboxrr\S3ResumableUploads\Http\Requests\CustomFormRequest;

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
            'path' => $this->getKey($this->file_identifier),
            'temporary_url' => Storage::disk('s3')->temporaryUrl(
                $this->getKey($this->file_identifier),
                now()->addMinutes(5)
            ),
            'url' => Storage::disk('s3')->url($this->getKey($this->file_identifier))
        ];
    }
}
