<?php

namespace Innoboxrr\S3ResumableUploads\Http\Requests\S3Multipart;

class InitiateUploadRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;  // Modificar según tus necesidades.
    }

    public function rules()
    {
        return [
            'filename' => 'required|string',
            'file_identifier' => 'required|string', 
        ];
    }

    public function handle()
    {
        
        $result = $this->s3->createMultipartUpload([
            'Bucket' => $this->bucket,
            'Key' => $this->getKey($this->file_identifier),
        ]);

        return ['upload_id' => $result['UploadId']];
    }

}