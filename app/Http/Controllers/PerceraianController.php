<?php

namespace App\Http\Controllers;

use App\Models\DokumenPerceraian;
use App\Models\IzinPerceraian;
use App\Models\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerceraianController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $data = IzinPerceraian::with('pegawai', 'creator', 'statusIzin')
                ->where('status_izin_perceraian_id', 2)
                ->latest()->get();
        } else {
            // OPD hanya lihat pengajuan dari pegawai di OPD-nya
            $pegawaiIds = Pegawai::where('opd', $user->name)->pluck('id');
            $data = IzinPerceraian::with('pegawai', 'creator', 'statusIzin')
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
            'nomor_surat' => ['nullable', 'string', 'max:100'],
            'surat_permohonan' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ];

        // Hanya admin yang bisa mengisi tanggal pemanggilan
        if (Auth::user()->hasRole('admin')) {
            $rules['tanggal_pemanggilan'] = ['nullable', 'date'];
        }

        $validated = $request->validate($rules);

        // Upload file surat permohonan
        if ($request->hasFile('surat_permohonan')) {
            $path = $request->file('surat_permohonan')->store('surat_permohonan', 'public');
            $validated['surat_permohonan'] = $path;
        }

        $validated['created_by'] = Auth::id();
        $validated['status_izin_perceraian_id'] = 1;

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
            'status_izin_perceraian_id' => ['nullable', 'integer', 'exists:status_izin_perceraian,id'],
            'catatan' => ['nullable', 'string'],
            'nomor_surat' => ['nullable', 'string', 'max:100'],
            'surat_permohonan' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ];

        // Hanya admin yang bisa mengisi tanggal pemanggilan
        if (Auth::user()->hasRole('admin')) {
            $rules['tanggal_pemanggilan'] = ['nullable', 'date'];
        }

        $validated = $request->validate($rules);

        // Upload file surat permohonan
        if ($request->hasFile('surat_permohonan')) {
            $path = $request->file('surat_permohonan')->store('surat_permohonan', 'public');
            $validated['surat_permohonan'] = $path;
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
        $perceraian->load('pegawai', 'dokumen', 'statusIzin', 'logTms.creator', 'beritaAcaraTambahan', 'beritaAcaraJawaban', 'beritaAcaraPemeriksa');
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

        // Simpan log jika TMS
        if ($value === -1) {
            $request->validate(['alasan' => ['required', 'string', 'max:1000']]);
            $perceraian->logTms()->create([
                'alasan' => $request->alasan,
                'created_by' => Auth::id(),
            ]);
            $perceraian->update(['status_izin_perceraian_id' => 1]);
        }

        return response()->json([
            'success' => true,
            'ms_tms' => $value,
            'message' => $value === 1 ? 'Status MS berhasil disimpan.' : 'Status TMS berhasil disimpan.',
        ]);
    }

    // Ajukan izin (ubah status draft -> pengajuan)
    public function ajukan(IzinPerceraian $perceraian)
    {
        $perceraian->update(['status_izin_perceraian_id' => 2]);
        return redirect()->route('perceraian.index')->with('success', 'Izin perceraian berhasil diajukan.');
    }

    // Print bukti pengajuan
    public function printPdf(IzinPerceraian $perceraian)
    {
        $this->authorizeAccess($perceraian);
        $perceraian->load('pegawai', 'dokumen', 'creator', 'statusIzin');
        return view('perceraian.print', compact('perceraian'));
    }

    // Generate surat panggilan PDF
    public function suratPanggilan(IzinPerceraian $perceraian)
    {
        $this->authorizeAccess($perceraian);

        $perceraian->load('pegawai.golongan');
        $pdf = Pdf::loadView('perceraian.surat_panggilan', compact('perceraian'));
        $pdf->setPaper('A4');

        $filename = "surat_panggilan_{$pihak}_{$perceraian->id}.pdf";
        return $pdf->stream($filename);
    }

    // Halaman laporan pemanggilan
    public function laporan(IzinPerceraian $perceraian)
    {
        $this->authorizeAccess($perceraian);
        $perceraian->load('pegawai.golongan', 'dokumen', 'creator', 'statusIzin', 'logTms.creator', 'beritaAcaraJawaban', 'beritaAcaraTambahan', 'beritaAcaraPemeriksa');
        $perceraian->pegawai->golongan;
        return view('perceraian.laporan', compact('perceraian'));
    }

    public function laporanPdf(IzinPerceraian $perceraian)
    {
        $this->authorizeAccess($perceraian);
        $perceraian->load('pegawai', 'dokumen', 'creator', 'statusIzin', 'logTms.creator', 'beritaAcaraJawaban', 'beritaAcaraTambahan', 'beritaAcaraPemeriksa');

        $sebutanPenggugat = $perceraian->sebagai === 'penggugat' ? 'Saudari' : 'Saudara';
        $sebutanTergugat = $perceraian->sebagai === 'tergugat' ? 'Saudari' : 'Saudara';

        $pdf = Pdf::loadView('perceraian.laporan_pdf', compact('perceraian', 'sebutanPenggugat', 'sebutanTergugat'));
        $pdf->setPaper('A4');
        return $pdf->stream('laporan_mediasi_' . $perceraian->id . '.pdf');
    }

    // Halaman rekomendasi BKPSDM
    public function rekomendasi(IzinPerceraian $perceraian)
    {
        $this->authorizeAccess($perceraian);
        $perceraian->load('pegawai', 'statusIzin');
        return view('perceraian.rekomendasi', compact('perceraian'));
    }

    // Halaman berita acara pemanggilan
    public function beritaAcara(IzinPerceraian $perceraian, string $pihak)
    {
        $this->authorizeAccess($perceraian);

        if (!in_array($pihak, ['penggugat', 'tergugat'])) {
            abort(404);
        }

        $perceraian->load('pegawai', 'statusIzin', 'beritaAcaraTambahan', 'beritaAcaraJawaban', 'beritaAcaraPemeriksa');
        $pemeriksa = \App\Models\Pegawai::where('opd', 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia')
            ->select('id', 'nama', 'nip', 'jabatan')
            ->orderBy('nama')
            ->get();
        return view('perceraian.berita_acara', compact('perceraian', 'pihak', 'pemeriksa'));
    }

    // Simpan berita acara
    public function simpanBeritaAcara(Request $request, IzinPerceraian $perceraian, string $pihak)
    {
        $this->authorizeAccess($perceraian);

        if (!in_array($pihak, ['penggugat', 'tergugat'])) {
            abort(404);
        }

        $validated = $request->validate([
            'berita_acara' => ['nullable', 'string'],
            'q_sehat' => ['nullable', 'string'],
            'q_menikah' => ['nullable', 'string'],
            'q_serumah' => ['nullable', 'string'],
            'q_alasan' => ['nullable', 'string'],
            'q_komunikasi' => ['nullable', 'string'],
            'q_yakin' => ['nullable', 'string'],
            'pemeriksa_nama_1' => ['nullable', 'string'],
            'pemeriksa_nip_1' => ['nullable', 'string'],
            'pemeriksa_jabatan_1' => ['nullable', 'string'],
        ]);

        $column = 'berita_acara_' . $pihak;
        $pihakVal = $pihak;

        // Simpan ke tabel berita_acara_jawaban
        $kodeMap = [
            'q_sehat' => 'q_sehat',
            'q_menikah' => 'q_menikah',
            'q_serumah' => 'q_serumah',
            'q_alasan' => 'q_alasan',
            'q_komunikasi' => 'q_komunikasi',
            'q_yakin' => 'q_yakin',
        ];
        foreach ($kodeMap as $field => $kode) {
            if ($request->filled($field)) {
                \App\Models\BeritaAcaraJawaban::updateOrCreate(
                    ['izin_perceraian_id' => $perceraian->id, 'pihak' => $pihakVal, 'kode' => $kode],
                    ['jawaban' => $request->input($field)]
                );
            }
        }

        // Simpan ke tabel berita_acara_pemeriksa
        $perceraian->beritaAcaraPemeriksa()->where('pihak', $pihakVal)->delete();
        for ($i = 1; $i <= 3; $i++) {
            $nama = $request->input("pemeriksa_nama_$i");
            if ($nama) {
                $perceraian->beritaAcaraPemeriksa()->create([
                    'pihak' => $pihakVal,
                    'urutan' => $i,
                    'nama' => $nama,
                    'nip' => $request->input("pemeriksa_nip_$i"),
                    'jabatan' => $request->input("pemeriksa_jabatan_$i"),
                ]);
            }
        }

        // Simpan juga ke compiled text (backward compat)
        if (empty($validated['berita_acara'])) {
            $text = '';
            for ($i = 1; $i <= 3; $i++) {
                $nama = $request->input("pemeriksa_nama_$i");
                if ($nama) {
                    $text .= "Pemeriksa $i: $nama\n";
                    $nip = $request->input("pemeriksa_nip_$i");
                    $jabatan = $request->input("pemeriksa_jabatan_$i");
                    if ($nip) $text .= "Pemeriksa $i NIP: $nip\n";
                    if ($jabatan) $text .= "Pemeriksa $i Jabatan: $jabatan\n";
                }
            }
            if ($text) $text .= "---\n";

            $labels = [
                'q_sehat' => '1. Sehat',
                'q_menikah' => '2. Lama Menikah',
                'q_serumah' => '3. Tinggal Serumah',
                'q_alasan' => '4. Alasan',
                'q_komunikasi' => '5. Komunikasi',
                'q_yakin' => '6. Yakin Berpisah',
            ];
            foreach ($labels as $field => $label) {
                if (!empty($validated[$field])) {
                    $text .= "$label: {$validated[$field]}\n";
                }
                $text .= "---\n";
            }
            $validated['berita_acara'] = $text;
        }

        $perceraian->update([$column => $validated['berita_acara']]);

        // Simpan pertanyaan tambahan
        if ($request->has('q_tambahan_tanya')) {
            $perceraian->beritaAcaraTambahan()->where('pihak', $pihak)->delete();
            foreach ($request->q_tambahan_tanya as $i => $tanya) {
                if (trim($tanya)) {
                    $perceraian->beritaAcaraTambahan()->create([
                        'pihak' => $pihak,
                        'pertanyaan' => $tanya,
                        'jawaban' => $request->q_tambahan_jawab[$i] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('perceraian.dokumen', $perceraian)
            ->with('success', 'Berita acara ' . $pihak . ' berhasil disimpan.');
    }

    // PDF Berita Acara
    public function beritaAcaraPdf(IzinPerceraian $perceraian, string $pihak)
    {
        $this->authorizeAccess($perceraian);

        if (!in_array($pihak, ['penggugat', 'tergugat'])) {
            abort(404);
        }

        $perceraian->load('pegawai', 'beritaAcaraTambahan', 'beritaAcaraJawaban', 'beritaAcaraPemeriksa');
        $pdf = Pdf::loadView('perceraian.berita_acara_pdf', compact('perceraian', 'pihak'));
        $pdf->setPaper('A4');

        return $pdf->stream('berita_acara_' . $pihak . '_' . $perceraian->id . '.pdf');
    }

    // Teruskan ke Walikota (gol >= 9)
    public function teruskanWalikota(IzinPerceraian $perceraian)
    {
        $this->authorizeAccess($perceraian);

        $perceraian->update([
            'status_izin_perceraian_id' => 4,
        ]);

        return redirect()->route('perceraian.dokumen', $perceraian)
            ->with('success', 'Pengajuan berhasil diteruskan ke Walikota.');
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
