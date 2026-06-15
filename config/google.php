<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google API Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk Google Drive API menggunakan Service Account.
    | Folder induk (parent_folder_id) adalah folder dari akun Google induk
    | yang sudah di-share ke Service Account.
    |
    */

    'drive' => [
        'service_account_json' => env('GOOGLE_SERVICE_ACCOUNT_JSON') ?: storage_path('app/google/service-account.json'),
        'parent_folder_id' => env('GOOGLE_DRIVE_PARENT_FOLDER_ID'),
    ],
];
