<?php

namespace App\Http\Controllers;

use App\Models\DokumenPerceraian;
use App\Models\IzinPerceraian;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerceraianController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $data = IzinPerceraian::with('pegawai', 'creator')->latest()->get();
        } else {
            // OPD hanya lihat pengajuan dari pegawai di OPD-nya
            $pegawaiIds = Pegawai::where('opd', $user->name)->pluck('id');
            $data = IzinPerceraian::with('pegawai', 'creator')
                ->whereIn('pegawai_id', $pegawaiIds)
                ->orWhere('created_by', $user->id)
                ->latest()->get();
        }

        return view('perceraian.index', compact('data'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $pegawai = Pegawai::orderBy('nama')->get();
        } else {
            $pegawai = Pegawai::where('opd', $user->name)->orderBy('nama')->get();
        }
        return view('perceraian.create', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $rules = [
            'pegawai_id' => ['required', 'exists:pegawai,id'],
            'nama_pasangan' => ['nullable', 'string', 'max:255'],
            'sebagai' => ['required', 'in:penggugat,tergugat'],
        ];

        // Hanya admin yang bisa mengisi tanggal & upload berita acara pemanggilan
        if (Auth::user()->hasRole('admin')) {
            $rules['tanggal_pemanggilan'] = ['nullable', 'date'];
            $rules['berita_acara_pemanggilan_file'] = ['nullable', 'file', 'mimes:pdf', 'max:10240'];
            $rules['ms_tms'] = ['nullable', 'in:-1,0,1'];
        }

        $validated = $request->validate($rules);

        // Upload file berita acara pemanggilan
        if (Auth::user()->hasRole('admin') && $request->hasFile('berita_acara_pemanggilan_file')) {
            $path = $request->file('berita_acara_pemanggilan_file')->store('berita_acara_pemanggilan', 'public');
            $validated['berita_acara_pemanggilan_file'] = $path;
        }

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'draft';

        $izin = IzinPerceraian::create($validated);

        // Buat checklist dokumen default
        $dokumen = [
            ['kode' => 'sk_pns',       'nama_dokumen' => 'Fotocopy SK PNS dan/atau Fotocopy SK Kenaikan Pangkat', 'wajib' => true],
            ['kode' => 'skp',           'nama_dokumen' => 'Fotocopy SKP', 'wajib' => true],
            ['kode' => 'kartu_keluarga','nama_dokumen' => 'Fotocopy Kartu Keluarga', 'wajib' => true],
            ['kode' => 'surat_nikah',   'nama_dokumen' => 'Fotocopy Surat Nikah', 'wajib' => true],
            ['kode' => 'surat_permohonan', 'nama_dokumen' => 'Surat Permohonan Izin Melakukan Perceraian kepada OPD yang bersangkutan', 'wajib' => true],
            ['kode' => 'panggilan_istri','nama_dokumen' => 'Surat Panggilan Untuk Istri', 'wajib' => true],
            ['kode' => 'panggilan_suami','nama_dokumen' => 'Surat Panggilan Untuk Suami', 'wajib' => true],
            ['kode' => 'kronologi',     'nama_dokumen' => 'Kronologi Kejadian/Berita Acara hasil Pemanggilan', 'wajib' => true],
            ['kode' => 'dokumentasi',   'nama_dokumen' => 'Dokumentasi (link Google Drive)', 'wajib' => true],
            ['kode' => 'surat_pernyataan', 'nama_dokumen' => 'Surat Pernyataan yang ditandatangani oleh yang bersangkutan, RT/RW, Lurah, dan Camat domisili yang bersangkutan (BILA DIPERLUKAN)', 'wajib' => false, 'kondisi_wajib' => 'pisah_rumah>=2_tahun'],
            ['kode' => 'bukti_lain',    'nama_dokumen' => 'Bukti (misal perselingkuhan dll)', 'wajib' => false],
        ];

        foreach ($dokumen as $d) {
            $izin->dokumen()->create($d);
        }

        return redirect()->route('perceraian.dokumen', $izin)
            ->with('success', 'Data izin perceraian berhasil dibuat. Silakan lengkapi dokumen pendukung.');
    }

    public function edit(IzinPerceraian $perceraian)
    {
        $this->authorizeAccess($perceraian);
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $pegawai = Pegawai::orderBy('nama')->get();
        } else {
            $pegawai = Pegawai::where('opd', $user->name)->orderBy('nama')->get();
        }
        return view('perceraian.edit', compact('perceraian', 'pegawai'));
    }

    public function update(Request $request, IzinPerceraian $perceraian)
    {
        $this->authorizeAccess($perceraian);

        $rules = [
            'pegawai_id' => ['required', 'exists:pegawai,id'],
            'nama_pasangan' => ['nullable', 'string', 'max:255'],
            'sebagai' => ['required', 'in:penggugat,tergugat'],
            'status' => ['nullable', 'in:draft,pengajuan,diproses,selesai,ditolak,pemanggilan'],
            'catatan' => ['nullable', 'string'],
        ];

        // Hanya admin yang bisa mengisi tanggal & upload berita acara pemanggilan
        if (Auth::user()->hasRole('admin')) {
            $rules['tanggal_pemanggilan'] = ['nullable', 'date'];
            $rules['berita_acara_pemanggilan_file'] = ['nullable', 'file', 'mimes:pdf', 'max:10240'];
            $rules['ms_tms'] = ['nullable', 'in:-1,0,1'];
        }

        $validated = $request->validate($rules);

        // Upload file berita acara pemanggilan
        if (Auth::user()->hasRole('admin') && $request->hasFile('berita_acara_pemanggilan_file')) {
            $path = $request->file('berita_acara_pemanggilan_file')->store('berita_acara_pemanggilan', 'public');
            $validated['berita_acara_pemanggilan_file'] = $path;
        }

        // Jika tanggal pemanggilan diisi, otomatis update status ke 'pemanggilan'
        if (Auth::user()->hasRole('admin') && $request->filled('tanggal_pemanggilan')) {
            $validated['status'] = 'pemanggilan';
        }

        $perceraian->update($validated);
        return redirect()->route('perceraian.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(IzinPerceraian $perceraian)
    {
        $this->authorizeAccess($perceraian);
        $perceraian->delete();
        return redirect()->route('perceraian.index')->with('success', 'Data berhasil dihapus.');
    }

    // Halaman kelola dokumen pendukung
    public function dokumen(IzinPerceraian $perceraian)
    {
        $perceraian->load('pegawai', 'dokumen');
        return view('perceraian.dokumen', compact('perceraian'));
    }

    // Update status checklist dokumen
    public function updateDokumen(Request $request, IzinPerceraian $perceraian, DokumenPerceraian $dokumen)
    {
        if ($dokumen->izin_perceraian_id !== $perceraian->id) {
            abort(404);
        }

        $data = $request->validate([
            'link' => ['nullable', 'string', 'max:500'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        // Dokumentasi & Bukti lain pakai link Google Drive folder
        if (in_array($dokumen->kode, ['dokumentasi', 'bukti_lain'])) {
            $data['file'] = null; // hapus file jika sebelumnya ada
        }
        // Upload file PDF (selain dokumentasi & bukti_lain)
        elseif ($request->hasFile('file')) {
            $request->validate(['file' => ['file', 'mimes:pdf', 'max:10240']]);
            $path = $request->file('file')->store('dokumen_perceraian', 'public');
            $data['file'] = $path;
        }

        // Status otomatis berdasarkan isi file/link
        $dokumen->update($data);
        $dokumen->refresh();

        if (in_array($dokumen->kode, ['dokumentasi', 'bukti_lain'])) {
            $dokumen->update(['status' => !empty($dokumen->link)]);
        } else {
            $dokumen->update(['status' => !empty($dokumen->file)]);
        }

        return back()->with('success', 'Dokumen berhasil diperbarui.');
    }

    // Buat folder Google Drive otomatis
    public function createDriveFolder(Request $request, IzinPerceraian $perceraian, DokumenPerceraian $dokumen)
    {
        if ($dokumen->izin_perceraian_id !== $perceraian->id) {
            abort(404);
        }

        if (!in_array($dokumen->kode, ['dokumentasi', 'bukti_lain'])) {
            return response()->json([
                'success' => false,
                'message' => 'Tipe dokumen ini tidak menggunakan Google Drive folder.',
            ], 400);
        }

        try {
            $service = new \App\Services\GoogleDriveService();

            $result = $service->createDokumenFolder(
                namaPegawai: $perceraian->pegawai->nama ?? 'Unknown',
                nip: $perceraian->pegawai->nip ?? '000000',
                izinId: $perceraian->id,
                kodeDokumen: $dokumen->kode,
                namaDokumen: $dokumen->nama_dokumen
            );

            if ($result['success']) {
                // Simpan link ke database
                $dokumen->update([
                    'link' => $result['link'],
                    'status' => true,
                ]);

                session()->flash('success', 'Folder Google Drive berhasil dibuat!');

                return response()->json([
                    'success' => true,
                    'link' => $result['link'],
                    'message' => 'Folder Google Drive berhasil dibuat!',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Update MS/TMS (hanya admin)
    public function updateMsTms(Request $request, IzinPerceraian $perceraian, int $value)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        if (!in_array($value, [-1, 1])) {
            return response()->json([
                'success' => false,
                'message' => 'Nilai tidak valid. Gunakan -1 (TMS) atau 1 (MS).',
            ], 400);
        }

        $perceraian->update(['ms_tms' => $value]);

        return response()->json([
            'success' => true,
            'ms_tms' => $value,
            'message' => $value === 1 ? 'Status MS berhasil disimpan.' : 'Status TMS berhasil disimpan.',
        ]);
    }

    // Ajukan izin (ubah status draft -> pengajuan)
    public function ajukan(IzinPerceraian $perceraian)
    {
        $perceraian->update(['status' => 'pengajuan']);
        return redirect()->route('perceraian.index')->with('success', 'Izin perceraian berhasil diajukan.');
    }

    // Print bukti pengajuan
    public function printPdf(IzinPerceraian $perceraian)
    {
        $this->authorizeAccess($perceraian);
        $perceraian->load('pegawai', 'dokumen', 'creator');
        return view('perceraian.print', compact('perceraian'));
    }

    private function authorizeAccess(IzinPerceraian $perceraian): void
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) return;

        // Cek apakah pegawai dalam OPD user
        $pegawai = $perceraian->pegawai;
        if (!$pegawai || $pegawai->opd !== $user->name) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
    }
}
