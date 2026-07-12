<?php

namespace App\Http\Controllers;

use App\Models\MasterOpd;
use App\Models\MasterUnitKerja;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{

    /**
     * Display a listing of pegawai filtered by OPD.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil daftar OPD dari master_opd untuk filter
        $opdList = MasterOpd::orderBy('nama_opd')->pluck('nama_opd');

        // Admin bisa lihat semua, OPD hanya lihat pegawai sesuai OPD-nya
        if ($user?->hasRole('admin')) {
            $query = Pegawai::with('golongan');
            if ($request->filled('opd')) {
                $query->where('opd', $request->opd);
            }
            $pegawai = $query->latest()->get();
        } else {
            $pegawai = Pegawai::with('golongan')->where('opd', $user->name)->latest()->get();
        }

        return view('pegawai.index', compact('pegawai', 'opdList'));
    }

    /**
     * Show the form for creating a new pegawai.
     */
    public function create()
    {
        $opdList = MasterOpd::orderBy('nama_opd')->get();
        return view('pegawai.create', compact('opdList'));
    }

    /**
     * Store a newly created pegawai.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nip'             => ['required', 'string', 'max:30'],
            'nama'            => ['required', 'string', 'max:255'],
            'jk'              => ['required', 'string', 'in:L,P'],
            'alamat'          => ['nullable', 'string'],
            'status_peg'      => ['nullable', 'string', 'max:50'],
            'tempat_lahir'    => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'   => ['nullable', 'date'],
            'agama'           => ['nullable', 'string', 'max:50'],
            'gelar_depan'     => ['nullable', 'string', 'max:50'],
            'gelar_belakang'  => ['nullable', 'string', 'max:100'],
            'jabatan'         => ['nullable', 'string', 'max:255'],
            'kode_unit'       => ['nullable', 'string', 'max:50'],
            'unit_kerja'      => ['nullable', 'string', 'max:255'],
            'opd'             => [$user->hasRole('admin') ? 'required' : 'nullable', 'string', 'max:255'],
            'status_menikah'  => ['nullable', 'string', 'max:50'],
            'nama_pasangan'   => ['nullable', 'string', 'max:255'],
            'tgl_menikah'     => ['nullable', 'date'],
            'pekerjaan'       => ['nullable', 'string', 'max:255'],
        ]);

        if (!$user->hasRole('admin')) {
            $validated['opd'] = $user->name;
        }

        Pegawai::create($validated);

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified pegawai.
     */
    public function edit(Pegawai $pegawai)
    {
        $this->authorizeAccess($pegawai);
        $opdList = MasterOpd::orderBy('nama_opd')->get();
        return view('pegawai.edit', compact('pegawai', 'opdList'));
    }

    /**
     * Update the specified pegawai.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $this->authorizeAccess($pegawai);

        $user = Auth::user();

        $validated = $request->validate([
            'nip'             => ['required', 'string', 'max:30'],
            'nama'            => ['required', 'string', 'max:255'],
            'jk'              => ['required', 'string', 'in:L,P'],
            'alamat'          => ['nullable', 'string'],
            'status_peg'      => ['nullable', 'string', 'max:50'],
            'tempat_lahir'    => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'   => ['nullable', 'date'],
            'agama'           => ['nullable', 'string', 'max:50'],
            'gelar_depan'     => ['nullable', 'string', 'max:50'],
            'gelar_belakang'  => ['nullable', 'string', 'max:100'],
            'jabatan'         => ['nullable', 'string', 'max:255'],
            'kode_unit'       => ['nullable', 'string', 'max:50'],
            'unit_kerja'      => ['nullable', 'string', 'max:255'],
            'opd'             => [$user->hasRole('admin') ? 'required' : 'nullable', 'string', 'max:255'],
            'status_menikah'  => ['nullable', 'string', 'max:50'],
            'nama_pasangan'   => ['nullable', 'string', 'max:255'],
            'tgl_menikah'     => ['nullable', 'date'],
            'pekerjaan'       => ['nullable', 'string', 'max:255'],
        ]);

        if (!$user->hasRole('admin')) {
            $validated['opd'] = $user->name;
        }

        $pegawai->update($validated);

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified pegawai.
     */
    public function destroy(Pegawai $pegawai)
    {
        $this->authorizeAccess($pegawai);
        $pegawai->delete();

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }

    /**
     * Ensure user can only access pegawai in their OPD.
     */
    private function authorizeAccess(Pegawai $pegawai): void
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && $pegawai->opd !== $user->name) {
            abort(403, 'Anda tidak memiliki akses ke data pegawai ini.');
        }
    }

    /**
     * Get unit kerja by OPD (for AJAX dependent dropdown).
     */
    public function getUnitKerja($opdId)
    {
        $unitKerja = MasterUnitKerja::where('opd_id', $opdId)
            ->orderBy('nama_unit')
            ->get(['id', 'kode_unit', 'nama_unit']);

        return response()->json($unitKerja);
    }
}
