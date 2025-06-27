<?php

namespace Innoboxrr\S3ResumableUploads\Http\Requests\S3Multipart;

use Illuminate\Foundation\Http\FormRequest;
use Innoboxrr\S3ResumableUploads\Support\Traits\S3Client;

class CustomFormRequest extends FormRequest
{

    use S3Client;

	protected $s3;

    protected $bucket;

    protected $key; // Clave de la ubicación de subida del file

    protected $filename; // Nombre del archivo

    public function __construct()
    {
        $this->s3 = $this->s3Client();
        $this->bucket = $this->s3Bucket();
    }

    /**
     * @var key hace referencia a la ubicación y nombre del archivo como se almacenará en AWS
     **/
    protected function getKey($fileIdentifier)
    {
        $filePath = config('s3resumableuploads.file_path', 'uploads');
        return "$filePath/$fileIdentifier/{$this->filename}";
    }

    protected function prepareForValidation()
    {
        $this->filename = $this->input('filename');
    }
    
}