<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\Log;

class GoogleDriveService
{
    protected Client $client;
    protected Drive $drive;

    /**
     * Inisialisasi Google Drive Client dengan Service Account.
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName('Izin Perceraian');

        $serviceAccountPath = config('google.drive.service_account_json');

        if (!file_exists($serviceAccountPath)) {
            throw new \RuntimeException(
                'File service account JSON tidak ditemukan di: ' . $serviceAccountPath .
                '. Buat file tersebut atau set GOOGLE_SERVICE_ACCOUNT_JSON di .env'
            );
        }

        $this->client->setAuthConfig($serviceAccountPath);
        $this->client->addScope(Drive::DRIVE_FILE);
        $this->client->setUseBatch(false);

        $this->drive = new Drive($this->client);
    }

    /**
     * Membuat folder di Google Drive di dalam folder induk (parent).
     *
     * @param string $folderName Nama folder yang akan dibuat
     * @param string|null $description Deskripsi folder (opsional)
     * @return array{success: bool, folder_id?: string, link?: string, message?: string}
     */
    public function createFolder(string $folderName, ?string $description = null): array
    {
        try {
            $parentFolderId = config('google.drive.parent_folder_id');

            if (empty($parentFolderId)) {
                throw new \RuntimeException(
                    'GOOGLE_DRIVE_PARENT_FOLDER_ID tidak dikonfigurasi. ' .
                    'Set di .env dengan ID folder Google Drive induk yang sudah di-share ke Service Account.'
                );
            }

            $fileMetadata = new DriveFile([
                'name' => $folderName,
                'description' => $description ?? '',
                'mimeType' => 'application/vnd.google-apps.folder',
                'parents' => [$parentFolderId],
            ]);

            $folder = $this->drive->files->create($fileMetadata, [
                'fields' => 'id, name, webViewLink',
            ]);

            $folderId = $folder->getId();
            $folderLink = $folder->getWebViewLink();

            // Jika webViewLink null, buat manual
            if (empty($folderLink)) {
                $folderLink = "https://drive.google.com/drive/folders/{$folderId}";
            }

            Log::info('Google Drive folder created', [
                'name' => $folderName,
                'folder_id' => $folderId,
                'link' => $folderLink,
            ]);

            return [
                'success' => true,
                'folder_id' => $folderId,
                'link' => $folderLink,
                'message' => 'Folder berhasil dibuat di Google Drive.',
            ];

        } catch (\Exception $e) {
            Log::error('Google Drive folder creation failed', [
                'name' => $folderName,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal membuat folder: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Membuat folder untuk dokumen perceraian dengan format nama terstruktur.
     *
     * @param string $namaPegawai
     * @param string $nip
     * @param int $izinId
     * @param string $kodeDokumen
     * @param string $namaDokumen
     * @return array
     */
    public function createDokumenFolder(
        string $namaPegawai,
        string $nip,
        int $izinId,
        string $kodeDokumen,
        string $namaDokumen
    ): array {
        // Format: NIP - Nama Dokumen
        $folderName = sprintf(
            '%s - %s',
            $nip,
            $namaDokumen
        );

        $description = sprintf(
            'Dokumen: %s | Izin ID: %d | %s (%s) | Kode: %s',
            $namaDokumen,
            $izinId,
            $namaPegawai,
            $nip,
            strtoupper($kodeDokumen)
        );

        return $this->createFolder($folderName, $description);
    }

    /**
     * Test koneksi ke Google Drive API.
     *
     * @return array{success: bool, message: string}
     */
    public function testConnection(): array
    {
        try {
            // Coba list folder di parent untuk test koneksi
            $parentFolderId = config('google.drive.parent_folder_id');

            if (empty($parentFolderId)) {
                return [
                    'success' => false,
                    'message' => 'GOOGLE_DRIVE_PARENT_FOLDER_ID belum dikonfigurasi.',
                ];
            }

            $this->drive->files->listFiles([
                'q' => "'{$parentFolderId}' in parents and trashed=false",
                'pageSize' => 1,
            ]);

            return [
                'success' => true,
                'message' => 'Koneksi ke Google Drive berhasil.',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Koneksi gagal: ' . $e->getMessage(),
            ];
        }
    }
}
