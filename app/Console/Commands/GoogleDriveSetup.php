<?php

namespace App\Console\Commands;

use App\Services\GoogleDriveService;
use Illuminate\Console\Command;

class GoogleDriveSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:google-drive-setup
                            {--test : Test koneksi ke Google Drive}
                            {--create-folder= : Buat folder test dengan nama tertentu}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup dan test koneksi Google Drive API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serviceAccountPath = config('google.drive.service_account_json');
        $parentFolderId = config('google.drive.parent_folder_id');

        $this->info('=== Google Drive Setup ===');
        $this->newLine();

        // Cek file Service Account
        $this->line('1. Service Account JSON:');
        if (file_exists($serviceAccountPath)) {
            $this->info("   ✅ File ditemukan: {$serviceAccountPath}");
        } else {
            $this->warn("   ❌ File tidak ditemukan: {$serviceAccountPath}");
            $this->line('   Solusi: Buat Service Account di Google Cloud Console,');
            $this->line('   download JSON key, dan simpan di path di atas.');
            $this->newLine();
            $this->line('   Atau set GOOGLE_SERVICE_ACCOUNT_JSON di .env');
            return 1;
        }

        // Cek Parent Folder ID
        $this->newLine();
        $this->line('2. Parent Folder ID:');
        if (!empty($parentFolderId)) {
            $this->info("   ✅ Terkonfigurasi: {$parentFolderId}");
        } else {
            $this->warn('   ❌ GOOGLE_DRIVE_PARENT_FOLDER_ID belum diisi di .env');
            $this->line('   Solusi: Share folder Google Drive ke email Service Account,');
            $this->line('   lalu isi ID folder tersebut di .env');
            return 1;
        }

        // Test koneksi
        if ($this->option('test') || $this->option('create-folder')) {
            $this->newLine();
            $this->line('3. Test Koneksi...');

            try {
                $service = new GoogleDriveService();

                if ($this->option('create-folder')) {
                    $name = $this->option('create-folder');
                    $this->line("   Membuat folder: {$name}...");
                    $result = $service->createFolder($name);

                    if ($result['success']) {
                        $this->info('   ✅ Folder berhasil dibuat!');
                        $this->line("   ID: {$result['folder_id']}");
                        $this->line("   Link: {$result['link']}");
                    } else {
                        $this->error("   ❌ {$result['message']}");
                        return 1;
                    }
                } else {
                    $result = $service->testConnection();
                    if ($result['success']) {
                        $this->info('   ✅ ' . $result['message']);
                    } else {
                        $this->error('   ❌ ' . $result['message']);
                        return 1;
                    }
                }
            } catch (\Exception $e) {
                $this->error('   ❌ Error: ' . $e->getMessage());
                return 1;
            }
        } else {
            $this->newLine();
            $this->line('   Gunakan --test untuk test koneksi');
            $this->line('   atau --create-folder="Nama Folder" untuk test membuat folder');
        }

        $this->newLine();
        $this->info('=== Setup selesai ===');

        return 0;
    }
}
