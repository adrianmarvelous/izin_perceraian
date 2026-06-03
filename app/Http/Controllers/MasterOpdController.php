<?php

namespace App\Http\Controllers;

use App\Models\MasterOpd;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterOpdController extends Controller
{
    /**
     * Display a listing of master OPD.
     */
    public function index()
    {
        $masterOpd = MasterOpd::withCount('unitKerja')->latest()->get();
        return view('master_opd.index', compact('masterOpd'));
    }

    /**
     * Show the form for creating a new master OPD.
     */
    public function create()
    {
        return view('master_opd.create');
    }

    /**
     * Store a newly created master OPD.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_opd' => ['required', 'string', 'max:50', 'unique:master_opd,kode_opd'],
            'nama_opd' => ['required', 'string', 'max:255'],
        ]);

        MasterOpd::create($validated);

        return redirect()->route('master-opd.index')
            ->with('success', 'Data master OPD berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified master OPD.
     */
    public function edit(MasterOpd $masterOpd)
    {
        return view('master_opd.edit', compact('masterOpd'));
    }

    /**
     * Update the specified master OPD.
     */
    public function update(Request $request, MasterOpd $masterOpd)
    {
        $validated = $request->validate([
            'kode_opd' => [
                'required', 'string', 'max:50',
                Rule::unique('master_opd', 'kode_opd')->ignore($masterOpd),
            ],
            'nama_opd' => ['required', 'string', 'max:255'],
        ]);

        $masterOpd->update($validated);

        return redirect()->route('master-opd.index')
            ->with('success', 'Data master OPD berhasil diperbarui.');
    }

    /**
     * Remove the specified master OPD.
     */
    public function destroy(MasterOpd $masterOpd)
    {
        $masterOpd->unitKerja()->delete();
        $masterOpd->delete();

        return redirect()->route('master-opd.index')
            ->with('success', 'Data master OPD beserta unit kerjanya berhasil dihapus.');
    }
}
