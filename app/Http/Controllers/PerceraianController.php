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
        $validated = $request->validate([
            'pegawai_id' => ['required', 'exists:pegawai,id'],
            'nama_pasangan' => ['nullable', 'string', 'max:255'],
            'sebagai' => ['required', 'in:penggugat,tergugat'],
        ]);

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

        $validated = $request->validate([
            'pegawai_id' => ['required', 'exists:pegawai,id'],
            'nama_pasangan' => ['nullable', 'string', 'max:255'],
            'sebagai' => ['required', 'in:penggugat,tergugat'],
            'status' => ['required', 'in:draft,pengajuan,diproses,selesai,ditolak'],
            'catatan' => ['nullable', 'string'],
        ]);

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

        // Upload file PDF (kecuali dokumentasi — pakai link)
        if ($dokumen->kode !== 'dokumentasi' && $request->hasFile('file')) {
            $request->validate(['file' => ['file', 'mimes:pdf', 'max:10240']]);
            $path = $request->file('file')->store('dokumen_perceraian', 'public');
            $data['file'] = $path;
        }

        // Status otomatis berdasarkan isi file/link
        $dokumen->update($data);
        $dokumen->refresh();

        if ($dokumen->kode === 'dokumentasi') {
            $dokumen->update(['status' => !empty($dokumen->link)]);
        } else {
            $dokumen->update(['status' => !empty($dokumen->file)]);
        }

        return back()->with('success', 'Dokumen berhasil diperbarui.');
    }

    // Ajukan izin (ubah status draft -> pengajuan)
    public function ajukan(IzinPerceraian $perceraian)
    {
        $perceraian->update(['status' => 'pengajuan']);
        return redirect()->route('perceraian.index')->with('success', 'Izin perceraian berhasil diajukan.');
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
