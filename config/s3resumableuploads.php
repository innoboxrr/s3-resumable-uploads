<?php

return [

	'file_path' => env('S3_RESUMABLE_UPLOADS_FILE_PATH', 'uploads'),

	'user_class' => 'App\Models\User',

	'excel_view' => 's3resumableuploads::excel.',

	'notification_via' => ['mail', 'database'],

	'export_disk' => 's3',
	
];