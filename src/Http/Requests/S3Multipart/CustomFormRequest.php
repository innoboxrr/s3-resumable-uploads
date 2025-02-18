<?php

namespace Innoboxrr\S3ResumableUploads\Http\Requests\S3Multipart;

use Illuminate\Foundation\Http\FormRequest;
use Innoboxrr\S3ResumableUploads\Support\Traits\S3Client;

class CustomFormRequest extends FormRequest
{

    use S3Client;

	protected $s3;

    protected $bucket;

    protected $key; // Clave de la ubicación de subida del video

    protected $filename; // Nombre del archivo

    public function __construct()
    {
        $this->s3 = $this->s3Client();
        $this->bucket = $this->s3Bucket();
    }

    /**
     * @var key hace referencia a la ubicación y nombre del archivo como se almacenará en AWS
     * Esto debe estár vinculado con getS3OriginalPathAttribute en VideoMutators
     **/
    protected function getKey($videoIdentifier)
    {
        // PENDIENTE:
        // Por ahora esto está condicionado a que los vidos en formato MP4
        // Más adelante debemos ver de que manera podemos manejar más formatos
        $videoPath = config('s3resumableuploads.file_path', 'uploads');

        return "$videoPath/$videoIdentifier/{$this->filename}";
    }

    protected function prepareForValidation()
    {
        $this->filename = $this->input('filename');
    }
    
}