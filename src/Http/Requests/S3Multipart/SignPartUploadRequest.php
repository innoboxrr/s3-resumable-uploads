<?php

namespace Innoboxrr\S3ResumableUploads\Http\Requests\S3Multipart;

use Innoboxrr\S3ResumableUploads\Http\Requests\CustomFormRequest;

class SignPartUploadRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file_identifier' => 'required|string',
            'upload_id' => 'required|string',
            'part_number' => 'required|integer',
        ];
    }

    public function handle()
    {
        
        $url = $this->s3->createPresignedRequest(
            $this->s3->getCommand('UploadPart', [
                'Bucket' => $this->bucket,
                'Key' => $this->getKey($this->file_identifier),
                'UploadId' => $this->upload_id,
                'PartNumber' => $this->part_number,
            ]),
            '+20 minutes'
        )->getUri();

        return ['url' => $url];
    }
}
