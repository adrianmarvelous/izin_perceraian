<?php

namespace App\Http\Controllers;

use App\Models\MasterOpd;
use App\Models\MasterUnitKerja;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterUnitKerjaController extends Controller
{
    /**
     * Display a listing of master unit kerja.
     */
    public function index()
    {
        $unitKerja = MasterUnitKerja::with('opd')->latest()->get();
        return view('master_unit_kerja.index', compact('unitKerja'));
    }

    /**
     * Show the form for creating a new master unit kerja.
     */
    public function create()
    {
        $opdList = MasterOpd::orderBy('nama_opd')->get();
        return view('master_unit_kerja.create', compact('opdList'));
    }

    /**
     * Store a newly created master unit kerja.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_unit' => ['required', 'string', 'max:50', 'unique:master_unit_kerja,kode_unit'],
            'nama_unit' => ['required', 'string', 'max:255'],
            'opd_id'    => ['nullable', 'integer', 'exists:master_opd,id'],
        ]);

        MasterUnitKerja::create($validated);

        return redirect()->route('master-unit-kerja.index')
            ->with('success', 'Data unit kerja berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified master unit kerja.
     */
    public function edit(MasterUnitKerja $masterUnitKerja)
    {
        $opdList = MasterOpd::orderBy('nama_opd')->get();
        return view('master_unit_kerja.edit', compact('masterUnitKerja', 'opdList'));
    }

    /**
     * Update the specified master unit kerja.
     */
    public function update(Request $request, MasterUnitKerja $masterUnitKerja)
    {
        $validated = $request->validate([
            'kode_unit' => [
                'required', 'string', 'max:50',
                Rule::unique('master_unit_kerja', 'kode_unit')->ignore($masterUnitKerja),
            ],
            'nama_unit' => ['required', 'string', 'max:255'],
            'opd_id'    => ['nullable', 'integer', 'exists:master_opd,id'],
        ]);

        $masterUnitKerja->update($validated);

        return redirect()->route('master-unit-kerja.index')
            ->with('success', 'Data unit kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified master unit kerja.
     */
    public function destroy(MasterUnitKerja $masterUnitKerja)
    {
        $masterUnitKerja->delete();

        return redirect()->route('master-unit-kerja.index')
            ->with('success', 'Data unit kerja berhasil dihapus.');
    }
}
