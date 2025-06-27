# 📦 Innoboxrr/S3ResumableUploads

Este paquete permite gestionar **cargas de archivos grandes en múltiples partes (multipart uploads)** hacia **Amazon S3**, utilizando rutas prefirmadas, protección CSRF y un flujo controlado desde Laravel.

---

## ✨ Características

* Compatible con cualquier frontend (Vue, React, JS puro, etc.)
* Firmado de partes individualmente para mayor seguridad
* Soporte para reintentos y cargas pausadas
* Integración con AWS S3 (vía SDK oficial)

---

## 📂 Endpoints disponibles

El sistema se compone de **3 requests** principales:

### 1. Iniciar carga (`InitiateUploadRequest`)

**Método:** `POST`
**Ruta sugerida:** `/api/upload/initiate`
**Body:**

```json
{
    "filename": "mi_archivo.pdf",
    "file_identifier": "unico-uuid-o-hash"
}
```

**Respuesta:**

```json
{
    "upload_id": "ABC123XYZ..."
}
```

---

### 2. Firmar parte (`SignPartUploadRequest`)

**Método:** `POST`
**Ruta sugerida:** `/api/upload/sign-part`
**Body:**

```json
{
    "file_identifier": "unico-uuid-o-hash",
    "upload_id": "ABC123XYZ...",
    "part_number": 1
}
```

**Respuesta:**

```json
{
    "url": "https://s3.amazonaws.com/tu-bucket/..."
}
```

Este `url` es donde el frontend sube la parte directamente vía `PUT`.

---

### 3. Completar carga (`CompleteUploadRequest`)

**Método:** `POST`
**Ruta sugerida:** `/api/upload/complete`
**Body:**

```json
{
    "filename": "mi_archivo.pdf",
    "file_identifier": "unico-uuid-o-hash",
    "upload_id": "ABC123XYZ...",
    "parts": [
        {
            "ETag": "\"etag-de-la-parte\"",
            "PartNumber": 1
        },
        ...
    ]
}
```

**Respuesta:**

```json
{
    "message": "Upload completed",
    "url": "https://s3.amazonaws.com/tu-bucket/uploads/unico-uuid-o-hash/mi_archivo.pdf"
}
```

---

## 🧩 Cómo funciona internamente

### `CustomFormRequest`

* Prepara y valida los datos comunes: `filename`, `file_identifier`, y construye dinámicamente la clave (`Key`) donde se almacenará el archivo en S3.
* Usa los traits `S3Client` para instanciar el cliente AWS y obtener el bucket configurado.

### `getKey()`

Construye el path completo del archivo en S3:

```php
/uploads/{file_identifier}/{filename}
```

Este path puede ser configurado usando:

```php
// config/s3resumableuploads.php
return [
    'file_path' => 'uploads'
];
```

---

## ⚙️ Requisitos

* Laravel 8+
* AWS SDK configurado (`config/filesystems.php`)
* Credenciales válidas con permisos de `s3:PutObject`, `s3:AbortMultipartUpload`, `s3:CompleteMultipartUpload`, etc.

---

## 🛠️ Instalación

```bash
composer require innoboxrr/s3-resumable-uploads
```

Agrega tus rutas:

```php
Route::post('/api/upload/initiate', InitiateUploadRequest::class);
Route::post('/api/upload/sign-part', SignPartUploadRequest::class);
Route::post('/api/upload/complete', CompleteUploadRequest::class);
```

---

## 🔐 Seguridad

* Todas las rutas esperan un token CSRF (`_token`)
* Se recomienda validar autorización en cada `authorize()` de los FormRequest según lógica propia del proyecto

---

## 📦 Estructura del paquete

```
Innoboxrr/
├── S3ResumableUploads/
│   ├── Http/
│   │   └── Requests/
│   │       └── S3Multipart/
│   │           ├── InitiateUploadRequest.php
│   │           ├── SignPartUploadRequest.php
│   │           ├── CompleteUploadRequest.php
│   └── Support/
│       └── Traits/
│           └── S3Client.php
```

---

¿Quieres que te genere también el archivo `config/s3resumableuploads.php` o los traits `S3Client`/`s3Bucket()` si aún no están definidos?
